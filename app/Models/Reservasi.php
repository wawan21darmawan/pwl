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
    }

    public function details()
    {
        return $this->hasMany(DetailReservasi::class, 'id_reservasi', 'id_reservasi');
    }

    protected $fillable = [
        'id_pengguna', 'id_meja', 'id_paket', 
        'tanggal_reservasi', 'jam_mulai', 'jam_selesai', 
        'total_bayar', 'metode_pembayaran'
    ];
}