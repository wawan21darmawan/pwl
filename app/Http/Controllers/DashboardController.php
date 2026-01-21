<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja; 

class DashboardController extends Controller
{
    
    public function index()
    {
        return view('dashboard');
    }

    public function reguler()
    {
        // Ambil data meja yang kategori ID-nya 1 (Reguler)
        $meja = Meja::where('id_kategori', 1)->get();
        return view('reguler', compact('meja'));
    }

    public function vipSmoking()
    {
        // Ambil data meja yang kategori ID-nya 2 (VIP Smoking)
        $meja = Meja::where('id_kategori', 2)->get();
        return view('vip-smoking', compact('meja'));
    }

    public function vipNonSmoking()
    {
        // Ambil data meja yang kategori ID-nya 3 (VIP Non-Smoking)
        $meja = Meja::where('id_kategori', 3)->get();
        return view('vip-non-smoking', compact('meja'));
    }
}