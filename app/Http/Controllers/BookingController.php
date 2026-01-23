<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\DB;
use App\Models\Meja;       
use App\Models\Reservasi;  
use App\Models\DetailReservasi; 
class BookingController extends Controller
{
    public function reguler()
    {
        // UPDATE 1: Ambil data meja kategori 1 (Reguler) 
        $meja = Meja::where('id_kategori', 1)->get();
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
        
        // Urutkan jam biar rapi
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
        $urlAsal = url()->previous(); 
        
        $hargaPerJam = 25000;
        $tipeRuangan = 'Reguler Area';
        $warnaTeks   = 'text-success'; 
        $idPaket     = 1; 

        if (str_contains($urlAsal, 'vip-non-smoking')) {
            $hargaPerJam = 40000;
            $tipeRuangan = 'VIP Non-Smoking';
            $warnaTeks   = 'text-info';
            $idPaket     = 3; 
        } 
        elseif (str_contains($urlAsal, 'vip-smoking') || str_contains($urlAsal, 'vip')) {
            $hargaPerJam = 40000;
            $tipeRuangan = 'VIP Smoking';
            $warnaTeks   = 'text-warning';
            $idPaket     = 2; 
        }

        $durasi = $request->jam_selesai - $request->jam_mulai;

        if ($durasi <= 0) {
            return redirect()->back()->with('error', 'Jam booking tidak valid');
        }

        $totalHarga = $durasi * $hargaPerJam;

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

    public function konfirmasiPembayaran(Request $request)
    {
        $request->validate([
            'id_meja'           => 'required',
            'tanggal_reservasi' => 'required',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'metode_pembayaran' => 'required'
        ]);

        $meja = Meja::find($request->id_meja);
        
        if (!$meja) {
            return redirect()->back()->with('error', 'Meja tidak ditemukan!');
        }

        $hargaPerJam = 25000; 
        $idPaket     = 1;     

        if ($meja->id_kategori == 2) { 
            $hargaPerJam = 40000; $idPaket = 2;
        } elseif ($meja->id_kategori == 3) {
            $hargaPerJam = 40000; $idPaket = 3; 
        }

        $durasi = (int)$request->jam_selesai - (int)$request->jam_mulai;
        if ($durasi < 1) $durasi = 1;
        
        $totalBayarFix = $durasi * $hargaPerJam;

        DB::transaction(function () use ($request, $totalBayarFix, $idPaket) {

            $reservasi = Reservasi::create([
                'id_pengguna'       => Auth::id(),
                'id_meja'           => $request->id_meja,
                'id_paket'          => $idPaket,
                'tanggal_reservasi' => $request->tanggal_reservasi,
                'jam_mulai'         => $request->jam_mulai . ':00:00',
                'jam_selesai'       => $request->jam_selesai . ':00:00',
                'total_bayar'       => $totalBayarFix, 
                'metode_pembayaran' => $request->metode_pembayaran,
                'status'            => 'pending'
            ]);

            DetailReservasi::create([
                'id_reservasi' => $reservasi->id_reservasi,
                'id_meja'      => $request->id_meja,
                'jam_mulai'    => $request->jam_mulai . ':00:00',
                'jam_selesai'  => $request->jam_selesai . ':00:00',
            ]);

        });

        return redirect('/dashboard')->with('success', 'Booking Berhasil! Selamat bermain.');
    }
}