<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman Regular
     */
    public function reguler()
    {
        return view('reguler');
    }

    public function vipSmoking()
    {
        return view('vip-smoking');
    }

    public function vip_nonSmoking()
    {
        return view('vip-non-smoking');
    }

    /**
     * Menerima data booking & menampilkan pembayaran
     */
    public function pembayaran(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'meja' => 'required',
            'jam_mulai' => 'required|integer',
            'jam_selesai' => 'required|integer',
            'tanggal_reservasi' => 'required|date',
        ]);

        // 2. DETEKSI OTOMATIS BERDASARKAN URL ASAL (Tanpa ubah view sebelumnya)
        $urlAsal = url()->previous(); // Mendapatkan link halaman sebelumnya
        
        // Default (Reguler)
        $hargaPerJam = 25000;
        $tipeRuangan = 'Reguler Area';
        $warnaTeks   = 'text-success'; // Hijau

        // Logika Pengecekan URL
        if (str_contains($urlAsal, 'vip-non-smoking')) {
            // Jika link mengandung kata 'vip-non-smoking'
            $hargaPerJam = 40000;
            $tipeRuangan = 'VIP Non-Smoking';
            $warnaTeks   = 'text-info'; // Biru Muda
        } 
        elseif (str_contains($urlAsal, 'vip-smoking') || str_contains($urlAsal, 'vip')) {
            // Jika link mengandung kata 'vip-smoking'
            $hargaPerJam = 40000;
            $tipeRuangan = 'VIP Smoking';
            $warnaTeks   = 'text-warning'; // Kuning
        }

        // 3. Hitung Durasi & Total
        $durasi = $request->jam_selesai - $request->jam_mulai;

        if ($durasi <= 0) {
            return redirect()->back()->with('error', 'Jam booking tidak valid');
        }

        $totalHarga = $durasi * $hargaPerJam;

        // 4. Kirim Data ke View Pembayaran
        return view('pembayaran', [
            'meja' => $request->meja,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'durasi' => $durasi,
            'totalHarga' => $totalHarga,     // Sudah dihitung
            'tipeRuangan' => $tipeRuangan,   // Hasil deteksi URL
            'warnaTeks' => $warnaTeks,       // Warna untuk CSS
            'hargaPerJam' => $hargaPerJam    // Untuk info tarif
        ]);
    }

    public function konfirmasiPembayaran(Request $request)
    {
        // (opsional) simpan transaksi / booking
        // Booking::create([...]);

        return redirect('/dashboard')
            ->with('success', 'Pembayaran berhasil, selamat bermain!');
    }
}
