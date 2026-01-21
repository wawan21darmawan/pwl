<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna'); 
        // Pastikan 'id' adalah primary key di tabel users/pengguna kamu
    }

    // Relasi ke Detail (Satu reservasi bisa punya detail rincian)
    public function details()
    {
        return $this->hasMany(DetailReservasi::class, 'id_reservasi', 'id_reservasi');
    }

    // Daftarkan kolom yang boleh diisi
    protected $fillable = [
        'id_pengguna', 'id_meja', 'id_paket', 
        'tanggal_reservasi', 'jam_mulai', 'jam_selesai', 
        'total_bayar', 'metode_pembayaran'
    ];
}