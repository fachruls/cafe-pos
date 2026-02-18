<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Item Belanjaan
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke Shift (Untuk laporan keuangan per shift)
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}