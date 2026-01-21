<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // untuk ambil ID user yang login
use Illuminate\Support\Facades\DB;
use App\Models\Meja;       
use App\Models\Reservasi;  
use App\Models\DetailReservasi; 
class BookingController extends Controller
{
    /**
     * Menampilkan halaman Regular (Mengambil data dari DB)
     */
    public function reguler()
    {
        // UPDATE 1: Ambil data meja kategori 1 (Reguler) dari Database
        $meja = Meja::where('id_kategori', 1)->get();
        
        // Kirim variable $meja ke view agar bisa di-looping
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

    public function cekKetersediaan(Request $request)
    {
        $id_meja = $request->id_meja;
        $tanggal = $request->tanggal;

        // Ambil data reservasi
        $reservasi = Reservasi::where('id_meja', $id_meja)
                        ->where('tanggal_reservasi', $tanggal)
                        ->get();
        $jamSibuk = [];

        foreach ($reservasi as $r) {
            // ubah jadi angka bulat
            $start = (int) substr($r->jam_mulai, 0, 2); 
            $end   = (int) substr($r->jam_selesai, 0, 2);

            if ($start >= $end) {
                continue; 
            }

            // Loop dari jam start sampai end
            for ($i = $start; $i < $end; $i++) {
                
                // Masukkan ke array hanya jika belum ada
                if (!in_array($i, $jamSibuk)) {
                    $jamSibuk[] = $i;
                }

                // Jika i tembus angka 24 paksa berhenti!
                if ($i > 24) break; 
            }
        }
        
        // Urutkan jam biar rapi (opsional)
        sort($jamSibuk);

        return response()->json($jamSibuk);
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

        // Deteksi URL 
        $urlAsal = url()->previous(); 
        
        $hargaPerJam = 25000;
        $tipeRuangan = 'Reguler Area';
        $warnaTeks   = 'text-success'; 
        // ID Paket untuk disimpan ke DB 
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
        // (Karena di form cuma kirim nomor meja, butuh ID aslinya untuk relasi DB)
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
        // 1. Validasi
        $request->validate([
            'id_meja' => 'required',
            'id_paket' => 'required',
            'tanggal_reservasi' => 'required',
            'total_bayar' => 'required',
            'metode_pembayaran' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        // 2. Gunakan Transaksi Database
        // Supaya kalau Detail gagal disimpan, Reservasi induk juga batal
        DB::transaction(function () use ($request) {
            
            // A. Simpan Reservasi (Induk)
            // Ditampung ke variabel $reservasiBaru agar kita bisa ambil ID-nya
            $reservasiBaru = Reservasi::create([
                'id_pengguna' => Auth::id(),
                'id_meja' => $request->id_meja,
                'id_paket' => $request->id_paket,
                'tanggal_reservasi' => $request->tanggal_reservasi,
                'jam_mulai' => $request->jam_mulai . ':00:00',   
                'jam_selesai' => $request->jam_selesai . ':00:00',
                'total_bayar' => $request->total_bayar,
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            // B. Simpan Detail Reservasi
            // Menggunakan ID dari reservasi yang baru dibuat di atas
            DetailReservasi::create([
                'id_reservasi' => $reservasiBaru->id_reservasi, 
                'id_meja' => $request->id_meja,
                'jam_mulai' => $request->jam_mulai . ':00:00',
                'jam_selesai' => $request->jam_selesai . ':00:00',
            ]);
        });

        // 3. Redirect
        // Ambil nomor meja untuk pesan sukses 
        return redirect('/dashboard')
            ->with('success', 'Pembayaran berhasil! Booking tercatat.');
    }
}