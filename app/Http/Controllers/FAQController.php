<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Pertanyaan;
use App\Models\Mahasiswa;
use App\Models\SaranPertanyaan;

class FAQController extends Controller
{
    // Menampilkan halaman FAQ beserta data kategori dan pertanyaan dari database
    public function index()
    {
        // Ambil semua kategori untuk filter dan dropdown modal
        $kategoris = Kategori::all();

        // Ambil semua pertanyaan yang berstatus published beserta relasi kategorinya
        $faqs = Pertanyaan::with('kategori')
                    ->where('status', 'published')
                    ->get()
                    ->map(function($item) {
                        return [
                            'id' => $item->id,
                            'category' => $item->kategori->nama ?? 'Umum',
                            'question' => $item->pertanyaan,
                            'answer' => $item->jawaban,
                            'helpful' => 0
                        ];
                    });

        // Kirim variabel $kategoris dan $faqs ke view
        return view('halaman.faqsearch', compact('kategoris', 'faqs'));
    }

    // Menangani verifikasi NRP mahasiswa
    public function verifyNrp(Request $request)
    {
        $request->validate(['nrp' => 'required|string|max:45']);
        
        // Cari atau buat data mahasiswa berdasarkan NRP
        $mahasiswa = Mahasiswa::firstOrCreate(['nrp' => $request->nrp]);

        return response()->json([
            'success' => true,
            'message' => 'NRP berhasil diverifikasi',
            'nrp' => $mahasiswa->nrp
        ]);
    }

    // Menangani pengiriman saran pertanyaan dari mahasiswa ke database
    public function storeSuggestion(Request $request)
    {
        $request->validate([
            'nrp' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'pertanyaan' => 'required|string',
        ]);

        // Temukan ID mahasiswa berdasarkan NRP
        $mahasiswa = Mahasiswa::where('nrp', $request->nrp)->first();
        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Simpan data saran pertanyaan ke database
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