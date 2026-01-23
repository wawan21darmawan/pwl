<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi Input 
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'no_telp'  => ['required'], 
        ]);

        // Login dengan 3 data sekaligus
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Jika Gagal
        return back()->withErrors([
            'username' => 'Username, Password, atau No. Telepon salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}