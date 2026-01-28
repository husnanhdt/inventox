<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required'
        ]);

        // Konversi "admin" → email admin
        $email = $request->email;
        if ($email === 'admin') {
            $email = 'admin@gmail.com'; // Sesuaikan dengan email admin kamu
        }

        // Validasi format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'Format email tidak valid.']);
        }

        // Coba login
        if (Auth::attempt(['email' => $email, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Kredensial salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
