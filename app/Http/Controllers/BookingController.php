<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Perlu untuk ambil ID user yang login
use App\Models\Meja;        // Panggil Model Meja
use App\Models\Reservasi;   // Panggil Model Reservasi (Pastikan sudah dibuat)

class BookingController extends Controller
{
    /**
     * Menampilkan halaman Regular (Mengambil data dari DB)
     */
    public function reguler()
    {
        // UPDATE 1: Ambil data meja kategori 1 (Reguler) dari Database
        $meja = Meja::where('id_kategori', 1)->get();
        
        // Kirim variable $meja ke view agar bisa di-looping (@foreach)
        return view('reguler', compact('meja'));
    }

    public function vipSmoking()
    {
        // UPDATE 1: Ambil data meja kategori 2 (VIP Smoking)
        $meja = Meja::where('id_kategori', 2)->get();
        return view('vip-smoking', compact('meja'));
    }

    public function vip_nonSmoking()
    {
        // UPDATE 1: Ambil data meja kategori 3 (VIP Non-Smoking)
        $meja = Meja::where('id_kategori', 3)->get();
        return view('vip-non-smoking', compact('meja'));
    }

    /**
     * Menerima data booking & menampilkan detail pembayaran
     */
    public function pembayaran(Request $request)
    {
        $request->validate([
            'meja' => 'required',
            'jam_mulai' => 'required|integer',
            'jam_selesai' => 'required|integer',
            'tanggal_reservasi' => 'required|date',
        ]);

        // Logika Deteksi URL kamu sudah bagus, kita pertahankan!
        $urlAsal = url()->previous(); 
        
        $hargaPerJam = 25000;
        $tipeRuangan = 'Reguler Area';
        $warnaTeks   = 'text-success'; 
        // ID Paket untuk disimpan ke DB (Sesuaikan dengan tabel paketharga)
        $idPaket     = 1; 

        if (str_contains($urlAsal, 'vip-non-smoking')) {
            $hargaPerJam = 40000;
            $tipeRuangan = 'VIP Non-Smoking';
            $warnaTeks   = 'text-info';
            $idPaket     = 3; // Asumsi ID 3 di tabel paketharga
        } 
        elseif (str_contains($urlAsal, 'vip-smoking') || str_contains($urlAsal, 'vip')) {
            $hargaPerJam = 40000;
            $tipeRuangan = 'VIP Smoking';
            $warnaTeks   = 'text-warning';
            $idPaket     = 2; // Asumsi ID 2 di tabel paketharga
        }

        $durasi = $request->jam_selesai - $request->jam_mulai;

        if ($durasi <= 0) {
            return redirect()->back()->with('error', 'Jam booking tidak valid');
        }

        $totalHarga = $durasi * $hargaPerJam;

        // Ambil ID Meja berdasarkan Nomor Meja yang dipilih
        // (Karena di form cuma kirim nomor meja, kita butuh ID aslinya untuk relasi DB)
        $dataMejaDB = Meja::where('nomor_meja', $request->meja)->first();

        return view('pembayaran', [
            'meja' => $request->meja,
            'id_meja_asli' => $dataMejaDB->id_meja ?? 0,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'durasi' => $durasi,
            'totalHarga' => $totalHarga,
            'tipeRuangan' => $tipeRuangan,
            'warnaTeks' => $warnaTeks,
            'id_paket' => $idPaket,
            'hargaPerJam' => $hargaPerJam 
        ]);
    }

    /**
     * UPDATE 2: MENYIMPAN DATA KE DATABASE
     */
    public function konfirmasiPembayaran(Request $request)
    {
        // Validasi data yang dikirim dari form hidden di halaman pembayaran
        $request->validate([
            'id_meja' => 'required',
            'id_paket' => 'required',
            'tanggal_reservasi' => 'required',
            'total_bayar' => 'required',
            'metode_pembayaran' => 'required'
        ]);

        // 1. Simpan ke Tabel Reservasi
        // Pastikan User sudah Login agar Auth::id() tidak error
        Reservasi::create([
            'id_pengguna' => Auth::id(), // Ambil ID user yang sedang login
            'id_meja' => $request->id_meja,
            'id_paket' => $request->id_paket,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'jam_mulai' => $request->jam_mulai . ':00:00',   // Format Time SQL
            'jam_selesai' => $request->jam_selesai . ':00:00',
            'total_bayar' => $request->total_bayar,
            'metode_pembayaran' => $request->metode_pembayaran
        ]);

        // 2. Update Status Meja jadi "terpesan" (Opsional, biar realtime)
        $meja = Meja::find($request->id_meja);
        if($meja) {
            $meja->status = 'terpesan';
            $meja->save();
        }

        return redirect('/dashboard')
            ->with('success', 'Pembayaran berhasil! Booking meja no ' . $meja->nomor_meja . ' tercatat.');
    }
}