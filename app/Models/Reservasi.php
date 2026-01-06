<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';
    public $timestamps = false;

    // Daftarkan kolom yang boleh diisi
    protected $fillable = [
        'id_pengguna', 'id_meja', 'id_paket', 
        'tanggal_reservasi', 'jam_mulai', 'jam_selesai', 
        'total_bayar', 'metode_pembayaran'
    ];
}