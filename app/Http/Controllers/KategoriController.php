<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

use DB;
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
        $kategori = new Kategori;

        $kategori->nama = $request->get('nama');
        $kategori->deskripsi = $request->get('deskripsi');

        $kategori->save();

        return redirect('/daftar-kategori');
    }

    public function ubah(Kategori $kategori)
    {
        return view('kategori.ubah', [
            'kategori' => $kategori
        ]);
    }

    public function update(request $request)
    {
        $kategori = Kategori::find($request->get('id'));

        $kategori->nama = $request->get('nama');
        $kategori->deskripsi = $request->get('deskripsi');

        $kategori->save();

        return redirect('daftar-kategori')
            ->with('success', 'Nama kategori berhasil diubah!');
    }

    public function delete($kategori)
    {
      $kategori = Kategori::find($kategori);
      $kategori->delete();
      return redirect('/daftar-kategori');
    }
}
