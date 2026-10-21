<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function tampil()
    {
        $kategori = Kategori::all();

        return view('kategori.daftar', [
            'kategoris' => $kategori
        ]);
    }

    public function create()
    {
        return view('kategori.create');
    }


    public function simpan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategoris,nama',
            'deskripsi' => 'required|nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.'
        ]);

        $kategori = new Kategori;
        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();

        return redirect('/daftar-kategori')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function ubah(Kategori $kategori)
    {
        return view('kategori.ubah', [
            'kategori' => $kategori
        ]);
    }

    
    public function update(Request $request)
    {
        $kategori = Kategori::findOrFail($request->id);

        $request->validate([
            'nama' => 'required|string|max:100|unique:kategoris,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.'
        ]);

        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();

        return redirect('/daftar-kategori')
            ->with('success', 'Kategori berhasil diubah!');
    }

    // Menghapus kategori
    public function delete($kategori)
    {
        $kategori = Kategori::findOrFail($kategori);
        $kategori->delete();

        return redirect('/daftar-kategori')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
