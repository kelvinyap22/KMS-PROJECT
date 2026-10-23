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
    $pertanyaans = DB::table('pertanyaans')
        ->join('kategoris', 'pertanyaans.kategori_id', '=', 'kategoris.id')
        ->select(
            'pertanyaans.*',
            'kategoris.nama as nama_kategori'
        )
        ->get();

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
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'pertanyaan'  => 'required',
            'jawaban'     => 'required',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'pertanyaan.required'  => 'Pertanyaan wajib diisi.',
            'jawaban.required'     => 'Jawaban wajib diisi.',
        ]);

        $pertanyaan = new Pertanyaan;

        $pertanyaan->kategori_id = $request->kategori_id;
        $pertanyaan->pertanyaan = $request->pertanyaan;
        $pertanyaan->jawaban = $request->jawaban;
        $pertanyaan->status = 'draft';

        $pertanyaan->save();

        return redirect('/daftar-pertanyaan')
            ->with('success', 'Pertanyaan berhasil disimpan sebagai draft.');
    }

   
    public function ubah(Pertanyaan $pertanyaan)
    {
        if ($pertanyaan->status === 'pending') {
            return redirect('/daftar-pertanyaan')
                ->with('error', 'Pertanyaan yang sudah dikirim ke validator tidak dapat diedit.');
        }

        $kategoris = Kategori::all();

        return view('pertanyaan.ubah', [
            'pertanyaan' => $pertanyaan,
            'kategoris' => $kategoris
        ]);
    }

    public function update(Request $request, Pertanyaan $pertanyaan)
    {
        // Validasi input
        $request->validate([
            'kategori_id' => 'required',
            'pertanyaan'  => 'required',
            'jawaban'     => 'required',
            'status'      => 'required|in:draft,pending,published,rejected',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'pertanyaan.required'  => 'Pertanyaan wajib diisi.',
            'jawaban.required'     => 'Jawaban wajib diisi.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status tidak valid. Pilih salah satu dari: draft, pending, published, rejected.',
        ]);

        $pertanyaan->kategori_id = $request->get('kategori_id');
        $pertanyaan->pertanyaan  = $request->get('pertanyaan');
        $pertanyaan->jawaban     = $request->get('jawaban');
        $pertanyaan->status      = $request->get('status');
        
        $pertanyaan->save();

        return redirect('/daftar-pertanyaan')->with('success', 'Pertanyaan berhasil diperbarui!');
    }
    
    public function delete(Pertanyaan $pertanyaan)
    {
        // Pertanyaan pending tidak boleh dihapus
        if ($pertanyaan->status === 'pending') {
            return redirect('/daftar-pertanyaan')
                ->with('error', 'Pertanyaan yang sudah dikirim ke validator tidak dapat dihapus.');
        }

        $pertanyaan->delete();

        return redirect('/daftar-pertanyaan')
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }

    
    public function kirim(Pertanyaan $pertanyaan)
    {
        if ($pertanyaan->status !== 'draft') {
            return redirect('/daftar-pertanyaan')
                ->with('error', 'Hanya pertanyaan berstatus draft yang dapat dikirim.');
        }

        $pertanyaan->status = 'pending';
        $pertanyaan->save();

        return redirect('/daftar-pertanyaan')
            ->with('success', 'Pertanyaan berhasil dikirim ke validator.');
    }

}