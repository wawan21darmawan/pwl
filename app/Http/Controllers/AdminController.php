<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class AdminController extends Controller
{
    public function index()
    {
        $dataReservasi = Reservasi::with(['user', 'details.meja.kategori'])
                            ->orderBy('id_reservasi', 'desc')
                            ->get();

        return view('admin.dashboard', compact('dataReservasi'));
    }
}