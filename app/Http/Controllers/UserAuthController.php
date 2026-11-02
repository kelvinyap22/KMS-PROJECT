<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        // Mencatat informasi untuk memeriksa proses login
        Log::info('Percobaan login staff', [
            'email' => $request->email,
            'session_id' => $request->session()->getId(),
            'csrf_session' => $request->session()->token(),
            'csrf_request' => $request->input('_token'),
        ]);

        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Memeriksa email dan password
        if (!Auth::attempt($credentials)) {
            return redirect()
                ->route('mahasiswa.login.form')
                ->with('error', 'Email atau password salah.');
        }

        // Membuat session baru setelah login berhasil
        $request->session()->regenerate();

        $user = Auth::user();

        // Mengarahkan user berdasarkan role_id
        switch ($user->role_id) {
            case 1:
                return redirect()->route('dataentry.index');

            case 2:
                return redirect()->route('validator.dashboard');

            case 3:
                return redirect()->route('superadmin.dashboard');

            default:
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('mahasiswa.login.form')
                    ->with('error', 'Role tidak dikenali.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('mahasiswa.login.form');
    }
}
