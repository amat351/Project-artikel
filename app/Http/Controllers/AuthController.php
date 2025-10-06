<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
    ]);

        if (Auth::user()->role === 'admin') {
            return redirect('/admin/posts');
        } elseif (Auth::user()->role === 'author') {
            return redirect('/author/posts');
        } else {
            return redirect('/');
        }

        return redirect('/');

        return back()->withErrors([
            'email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
          'name' => 'required|string|max:255',
          'username' => 'required|string|max:50|unique:users,username',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'email_verified_at' => now(),
        'password' => bcrypt($request->password),
        'remember_token' => Str::random(10),
        ]);

        Auth::login($user);

        return redirect('/');
    }
}
