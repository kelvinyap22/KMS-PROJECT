<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;

class ValidatorController extends Controller
{
    // Memastikan hanya role Validator yang bisa mengakses
    private function checkValidator()
    {
        abort_unless(
            auth()->check() &&
            auth()->user()->role?->nama === 'Validator',
            403,
            'Anda tidak memiliki akses ke halaman Validator.'
        );
    }

    // Menampilkan daftar pertanyaan yang menunggu validasi
    public function index()
    {
        $this->checkValidator();

        $pertanyaans = Pertanyaan::with(['kategori', 'creator', 'reviewer'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('staff.validator.index', compact('pertanyaans'));
    }

    // Menyetujui pertanyaan dan jawaban
    public function approve(Pertanyaan $pertanyaan)
    {
        $this->checkValidator();

        if ($pertanyaan->status !== 'pending') {
            return back()->with('error', 'Pertanyaan ini sudah diperiksa.');
        }

        $pertanyaan->update([
            'status' => 'published',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'catatan_review' => null,
        ]);

        return back()->with('success', 'Pertanyaan dan jawaban berhasil disetujui dan dipublikasikan.');
    }

    // Menolak pertanyaan dan jawaban
    public function reject(Request $request, Pertanyaan $pertanyaan)
    {
        $this->checkValidator();

        $request->validate([
            'catatan_review' => 'required|string|max:1000',
        ], [
            'catatan_review.required' => 'Alasan penolakan wajib diisi.',
            'catatan_review.max' => 'Catatan maksimal 1000 karakter.',
        ]);

        if ($pertanyaan->status !== 'pending') {
            return back()->with('error', 'Pertanyaan ini sudah diperiksa.');
        }

        $pertanyaan->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'catatan_review' => $request->catatan_review,
        ]);

        return back()->with('success', 'Pertanyaan berhasil ditolak. Catatan penolakan telah disimpan.');
    }
}
