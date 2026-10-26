<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Pertanyaan;
use App\Models\Kategori;
use App\Models\SaranPertanyaan;
use DB;

class StudentFaqController extends Controller
{
    public function index() {
        $kategoris = Kategori::all();
        // Ambil pertanyaan dengan relasi kategori, filter status published
        $faqs = Pertanyaan::with('kategori')
                    ->where('status', 'published')
                    ->get()
                    ->map(function($item) {
                        return [
                            'id' => $item->id,
                            'category' => $item->kategori->nama ?? 'Umum',
                            'question' => $item->pertanyaan,
                            'answer' => $item->jawaban,
                            'helpful' => 0 // Bisa ditambahkan kolom counter di DB jika ingin persistent
                        ];
                    });

        return view('kms.index', compact('faqs', 'kategoris'));
    }
    public function verifyNrp(Request $request) {
        $request->validate(['nrp' => 'required|string|max:45']);
        
        $mahasiswa = Mahasiswa::firstOrCreate(['nrp' => $request->nrp]);
        session(['mahasiswa_id' => $mahasiswa->id, 'nrp' => $mahasiswa->nrp]);

        return response()->json([
            'success' => true,
            'message' => 'NRP berhasil diverifikasi',
            'nrp' => $mahasiswa->nrp
        ]);
    }
    public function storeSuggestion(Request $request) {
        $request->validate([
            'nrp' => 'required|string',
            'pertanyaan' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::where('nrp', $request->nrp)->first();
        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        SaranPertanyaan::create([
            'pertanyaan' => $request->pertanyaan,
            'mahasiswa_id' => $mahasiswa->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Saran pertanyaan berhasil dikirim ke Data Entry!'
        ]);
    }
}
