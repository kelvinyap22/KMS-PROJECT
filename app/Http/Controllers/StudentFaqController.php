<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Pertanyaan;
use App\Models\Kategori;
use App\Models\SaranPertanyaan;

class StudentFaqController extends Controller
{
    // Menampilkan halaman utama FAQ mahasiswa
    public function index()
    {
        $kategoris = Kategori::orderBy('nama')->get();

        $faqs = Pertanyaan::with('kategori')
            ->where('status', 'published')
            ->get()
            ->map(function ($item) {

                return [
                    'id' => $item->id,
                    'category' => $item->kategori->nama ?? 'Umum',
                    'question' => $item->pertanyaan,
                    'answer' => $item->jawaban,
                ];

            });

        return view('kms.index', compact('faqs', 'kategoris'));
    }


    // Menyimpan saran pertanyaan mahasiswa
    public function storeSuggestion(Request $request)
    {
        // Pastikan mahasiswa sudah login
        $mahasiswaId = session('mahasiswa_id');

        if (!$mahasiswaId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        // Validasi pertanyaan
        $validated = $request->validate([
            'pertanyaan' => 'required|string|min:5|max:1000',
        ]);

        // Pastikan data mahasiswa masih tersedia
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        if (!$mahasiswa) {
            $request->session()->forget(['mahasiswa_id', 'nrp']);

            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan. Silakan login kembali.'
            ], 404);
        }

        // Simpan saran pertanyaan
        SaranPertanyaan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'pertanyaan' => $validated['pertanyaan'],
            'ditangani_oleh' => null,
            'status' => 'baru',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Saran pertanyaan berhasil dikirim ke Tim Data Entry!'
        ]);
    }
}
