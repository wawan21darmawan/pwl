<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMeja extends Model
{
    use HasFactory;

    protected $table = 'kategorimeja'; 
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
}