<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReservasi extends Model
{
    use HasFactory; 

    protected $table = 'detailreservasi';
    protected $primaryKey = 'id_detail';
    public $timestamps = false; 

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja', 'id_meja');
    }

    protected $fillable = [
        'id_reservasi',
        'id_meja',
        'jam_mulai',
        'jam_selesai',
    ];
}