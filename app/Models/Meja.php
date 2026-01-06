<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    // Menyesuaikan dengan nama tabel di SQL kamu
    protected $table = 'meja';
    protected $primaryKey = 'id_meja';
    public $timestamps = false; // Karena di SQL tidak ada created_at/updated_at

    protected $fillable = ['nomor_meja', 'id_kategori', 'status'];
}