<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'password' => 'required',
            'no_telp' => 'required'
        ]);

        if (
            $request->nama === 'admin' &&
            $request->password === '123' &&
            $request->no_telp === '081'
        ) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'Login gagal');
    }
}
