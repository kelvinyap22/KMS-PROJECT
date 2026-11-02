<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role_id) {

                case 1:
                    return redirect()->route('admin.dashboard');

                case 2:
                    return redirect()->route('dataentry.index');

                case 3:
                    return redirect()->route('superadmin.dashboard');

                case 4:
                    return redirect()->route('validator.dashboard');

                default:
                    Auth::logout();

                    return redirect('/')
                        ->with('error', 'Role tidak dikenali.');
            }
        }

        return redirect('/')
            ->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
