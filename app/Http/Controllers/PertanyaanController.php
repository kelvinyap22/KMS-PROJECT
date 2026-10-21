<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Kategori;
use DB;

class PertanyaanController extends Controller
{
    public function tampil()
    {
        $pertanyaans = Pertanyaan::with('kategori')->get();

        return view('pertanyaan.daftar', [
            'pertanyaans' => $pertanyaans
        ]);
    }
    public function create()
    {
        $kategoris = Kategori::all();

        return view('pertanyaan.create', [
            'kategoris' => $kategoris
        ]);
    }
    public function simpan(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori_id' => 'required',
            'pertanyaan'  => 'required',
            'jawaban'     => 'required',
            'status'      => 'required|in:draft,pending,published,rejected',
        ]);
        $pertanyaan = new Pertanyaan;
        $pertanyaan->kategori_id = $request->get('kategori_id');
        $pertanyaan->pertanyaan  = $request->get('pertanyaan');
        $pertanyaan->jawaban     = $request->get('jawaban');
        $pertanyaan->status      = $request->get('status');
        
        $pertanyaan->save();

        return redirect('/daftar-pertanyaan')->with('success', 'Pertanyaan berhasil ditambahkan!');
    }
}