<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // --- TAMBAHKAN BAGIAN INI ---
    protected $table = 'pengguna';      // Nama tabel di database kamu
    protected $primaryKey = 'id_pengguna'; // Nama primary key kamu
    public $timestamps = false;         // Karena di tabel pengguna tidak ada created_at & updated_at
    // ----------------------------

    protected $fillable = [
        'username', // Sesuaikan dengan kolom database
        'password',
        'no_telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Hapus method casts() jika membuat error, atau biarkan default
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}