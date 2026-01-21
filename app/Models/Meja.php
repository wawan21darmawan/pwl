<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'meja';
    protected $primaryKey = 'id_meja';
    public $timestamps = false; 
    protected $guarded = [];

    protected $fillable = ['nomor_meja', 'id_kategori', 'status'];
    public function kategori()
    {
        return $this->belongsTo(KategoriMeja::class, 'id_kategori', 'id_kategori');
    }
}