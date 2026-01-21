<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';    
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;         // Karena di tabel pengguna tidak ada created_at & updated_at

    protected $fillable = [
        'username', 
        'password',
        'no_telp',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}