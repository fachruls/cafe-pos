<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kita memproteksi ID saja, sisanya boleh diisi massal
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // --- RELASI KE TABEL LAIN ---

    // Satu User bisa punya banyak Shift (Riwayat kerja)
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    // --- LOGIC TAMBAHAN ---

    // Helper untuk cek apakah user ini sedang punya shift yang statusnya "open"
    // Digunakan nanti di Middleware untuk memblokir akses jika belum buka shift
    public function activeShift()
    {
        return $this->hasOne(Shift::class)->where('status', 'open')->latest();
    }
}