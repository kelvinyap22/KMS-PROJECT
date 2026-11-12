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
    public function store(Request $request)
{
    $request->validate([
        'kategori_id' => 'required|exists:kategoris,id',
        'pertanyaan' => 'required|string|max:255',
        'jawaban' => 'required|string',
        'saran_id' => 'nullable|exists:saran_pertanyaans,id',
    ]);

    \Illuminate\Support\Facades\DB::transaction(function () use ($request) {

        // Simpan FAQ ke tabel pertanyaans
        Pertanyaan::create([
            'kategori_id' => $request->kategori_id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
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
