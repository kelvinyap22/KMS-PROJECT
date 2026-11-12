<?php
namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Kategori;
use App\Models\SaranPertanyaan;
use Illuminate\Http\Request;

class DataEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = Pertanyaan::with('kategori');

        // Pencarian pertanyaan
        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pertanyaans = $query->latest()->paginate(10)->withQueryString();

        $kategoris = Kategori::all();

        $totalPertanyaan = Pertanyaan::count();

        $totalPending = Pertanyaan::where('status', 'pending')->count();

        $totalPublished = Pertanyaan::where('status', 'published')->count();

        $totalDraft = Pertanyaan::where('status', 'draft')->count();

        $totalRejected = Pertanyaan::where('status', 'rejected')->count();

        $saranPertanyaans = SaranPertanyaan::with('mahasiswa')
    ->latest()
    ->get();

        return view('dataentry.index', compact(
            'pertanyaans',
            'kategoris',
            'totalPertanyaan',
            'totalPending',
            'totalPublished',
            'totalDraft',
            'totalRejected',
            'saranPertanyaans'
        ));
    }

    // Tambah pertanyaan
    
// Tambah pertanyaan dengan validasi kemiripan
public function store(Request $request)
{
    $validated = $request->validate([
        'kategori_id' => 'required|exists:kategoris,id',
        'pertanyaan' => 'required|string|max:255',
        'jawaban' => 'required|string',
        'saran_id' => 'nullable|exists:saran_pertanyaans,id',
    ]);

    // Periksa kemiripan sebelum menyimpan
    // Pemeriksaan dilewati jika Data Entry sudah memilih Tetap Simpan
    if (!$request->boolean('force_save')) {

        $similarQuestions = $this->findSimilarQuestions(
            $validated['pertanyaan']
        );

        if ($similarQuestions->isNotEmpty()) {

            return redirect()->back()
                ->withInput()
                ->with('similar_questions', $similarQuestions->toArray())
                ->with('warning', 'Ditemukan pertanyaan yang mirip. Periksa terlebih dahulu sebelum menyimpan.');
        }
    }

    \Illuminate\Support\Facades\DB::transaction(function () use ($request, $validated) {

        // Simpan FAQ ke tabel pertanyaans
        Pertanyaan::create([
            'kategori_id' => $validated['kategori_id'],
            'pertanyaan' => $validated['pertanyaan'],
            'jawaban' => $validated['jawaban'],
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        // Jika FAQ berasal dari saran mahasiswa
        if ($request->filled('saran_id')) {

            SaranPertanyaan::where('id', $request->saran_id)
                ->update([
                    'status' => 'selesai',
                    'ditangani_oleh' => auth()->id(),
                ]);
        }
    });

    return redirect()->route('dataentry.index')
        ->with('success', 'Pertanyaan berhasil ditambahkan.');
}


// ========================================
// DETEKSI KEMIRIPAN PERTANYAAN
// ========================================

private function findSimilarQuestions($newQuestion)
{
    // Ambil pertanyaan yang sudah ada.
    // Pertanyaan berstatus rejected tidak ikut dibandingkan.
    $existingQuestions = Pertanyaan::where('status', '!=', 'rejected')
        ->get(['id', 'pertanyaan', 'status']);

    if ($existingQuestions->isEmpty()) {
        return collect();
    }

    // Gabungkan pertanyaan baru dengan seluruh pertanyaan lama
    $documents = collect([$newQuestion])
        ->concat($existingQuestions->pluck('pertanyaan'));

    // Ubah seluruh pertanyaan menjadi token
    $tokenizedDocuments = $documents->map(function ($question) {
        return $this->tokenizeQuestion($question);
    });

    // Hitung document frequency setiap kata
    $documentFrequency = [];

    foreach ($tokenizedDocuments as $tokens) {

        foreach (array_unique($tokens) as $token) {

            $documentFrequency[$token] =
                ($documentFrequency[$token] ?? 0) + 1;
        }
    }

    $totalDocuments = $tokenizedDocuments->count();

    // Hitung IDF
    $idf = [];

    foreach ($documentFrequency as $word => $frequency) {

        $idf[$word] = log(
            ($totalDocuments + 1) / ($frequency + 1)
        ) + 1;
    }

    // Buat vektor pertanyaan baru
    $newVector = $this->buildTfIdfVector(
        $tokenizedDocuments[0],
        $idf
    );

    $results = [];

    foreach ($existingQuestions as $index => $existing) {

        $existingVector = $this->buildTfIdfVector(
            $tokenizedDocuments[$index + 1],
            $idf
        );

        $similarity = $this->cosineSimilarity(
            $newVector,
            $existingVector
        );

        // Ambang batas kemiripan 40%
        if ($similarity >= 0.40) {

            $results[] = [
                'id' => $existing->id,
                'pertanyaan' => $existing->pertanyaan,
                'status' => $existing->status,
                'similarity' => round($similarity * 100),
            ];
        }
    }

    // Urutkan dari yang paling mirip
    return collect($results)
        ->sortByDesc('similarity')
        ->take(3)
        ->values();
}


// ========================================
// NORMALISASI DAN TOKENISASI
// ========================================

private function tokenizeQuestion($question)
{
    $question = mb_strtolower($question, 'UTF-8');

    // Hilangkan tanda baca
    $question = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $question);

    $words = preg_split('/\s+/u', trim($question));

    // Kata umum yang tidak terlalu berpengaruh
    $stopWords = [
        'bagaimana', 'cara', 'apa', 'apakah',
        'siapa', 'kapan', 'dimana', 'di', 'ke',
        'dari', 'yang', 'dan', 'atau', 'untuk',
        'dengan', 'pada', 'dalam', 'adalah',
        'itu', 'ini', 'sudah', 'akan', 'bisa',
        'kah', 'mengapa', 'bisakah', 'dapat',
        'saya', 'kami', 'anda', 'sebuah',
        'suatu', 'tersebut', 'oleh'
    ];

    return array_values(array_filter($words, function ($word) use ($stopWords) {

        return $word !== ''
            && !in_array($word, $stopWords)
            && mb_strlen($word, 'UTF-8') > 1;
    }));
}


// ========================================
// MEMBUAT VEKTOR TF-IDF
// ========================================

private function buildTfIdfVector($tokens, $idf)
{
    $wordCounts = array_count_values($tokens);

    $vector = [];

    foreach ($wordCounts as $word => $count) {

        $vector[$word] = $count * ($idf[$word] ?? 0);
    }

    return $vector;
}


// ========================================
// COSINE SIMILARITY
// ========================================

private function cosineSimilarity($vectorA, $vectorB)
{
    if (empty($vectorA) || empty($vectorB)) {
        return 0;
    }

    $dotProduct = 0;

    foreach ($vectorA as $word => $value) {

        if (isset($vectorB[$word])) {

            $dotProduct += $value * $vectorB[$word];
        }
    }

    $magnitudeA = sqrt(
        array_sum(array_map(
            fn($value) => $value * $value,
            $vectorA
        ))
    );

    $magnitudeB = sqrt(
        array_sum(array_map(
            fn($value) => $value * $value,
            $vectorB
        ))
    );

    if ($magnitudeA == 0 || $magnitudeB == 0) {
        return 0;
    }

    return $dotProduct / ($magnitudeA * $magnitudeB);
}


    // Edit pertanyaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
        ]);

        $pertanyaan = Pertanyaan::findOrFail($id);

        $pertanyaan->update([
            'kategori_id' => $request->kategori_id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->route('dataentry.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    // Hapus pertanyaan
    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $pertanyaan->delete();

        return redirect()->route('dataentry.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }

    // Kirim pertanyaan ke Validator
    public function kirim($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        if (!in_array($pertanyaan->status, ['draft', 'rejected'])) {
            return redirect()->route('dataentry.index')
                ->with('error', 'Pertanyaan tidak dapat dikirim.');
        }

        $pertanyaan->update([
            'status' => 'pending',
        ]);

        return redirect()->route('dataentry.index')
            ->with('success', 'Pertanyaan berhasil dikirim ke Validator.');
    }
    // Menandai saran sebagai selesai atau ditolak
    public function updateStatusSaran(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
        ]);

        $saran = SaranPertanyaan::findOrFail($id);

        $saran->update([
            'status' => $request->status,
            'ditangani_oleh' => auth()->id(),
        ]);

        return redirect()->route('dataentry.index')
            ->with('success', 'Status saran pertanyaan berhasil diperbarui.');
    }
}
