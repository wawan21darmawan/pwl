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
        // 1. Validasi Input (Wajibkan no_telp juga)
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'no_telp'  => ['required'], // Tambahkan validasi ini
        ]);

        // 2. Coba Login dengan 3 data sekaligus
        // Auth::attempt akan mencocokkan semua key array di atas dengan kolom database
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