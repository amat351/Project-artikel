<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    // 1. Validasi input + captcha
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
        'g-recaptcha-response' => 'required',
    ], [
        // Custom pesan error
        'g-recaptcha-response.required' => 'Silakan centang kotak reCAPTCHA',
    ]);

    // ✅ Verifikasi ke Google reCAPTCHA
    $response = file_get_contents(
        'https://www.google.com/recaptcha/api/siteverify?secret='
        . env('NOCAPTCHA_SECRET')
        . '&response=' . $request->input('g-recaptcha-response')
    );
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        return back()->withErrors(['captcha' => 'Captcha tidak valid, coba lagi.']);
    }

    // 3. Kalau captcha valid → lanjut login
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        
        if (Auth::user()->role === 'superadmin') {
            return redirect('/');
        } elseif (Auth::user()->role === 'admin') {
            return redirect('/admin/posts');
        } elseif (Auth::user()->role === 'author') {
            return redirect('/author/posts');
        } else {
        }    return redirect('/posts');
         {
        }

    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
