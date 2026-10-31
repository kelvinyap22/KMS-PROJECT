<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaAuthController extends Controller
{
    public function showLogin()
    {
        return view('mahasiswa.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nrp' => 'required|string|max:45',
        ]);

        $mahasiswa = Mahasiswa::where('nrp', $request->nrp)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'NRP tidak terdaftar dalam sistem.'
            ], 404);
        }

        $request->session()->regenerate();

        session([
            'mahasiswa_id' => $mahasiswa->id,
            'nrp' => $mahasiswa->nrp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'NRP berhasil diverifikasi.',
            'nrp' => $mahasiswa->nrp,
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'mahasiswa_id',
            'nrp',
        ]);

        $request->session()->regenerateToken();

        return redirect('/login-mahasiswa');
    }
}