<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQController extends Controller
{
    // Menampilkan halaman FAQ
    public function index()
    {
        return view('halaman.faqsearch');
    }

    // Menangani pengiriman saran pertanyaan dari mahasiswa
    public function storeSuggestion(Request $request)
    {
        $request->validate([
            'nrp' => 'required',
            'category' => 'required',
            'question' => 'required',
        ]);

        // Simpan data ke database di sini
        // Example: QuestionSuggestion::create($request->all());

        return response()->json(['message' => 'Saran pertanyaan berhasil dikirim!']);
    }
}
