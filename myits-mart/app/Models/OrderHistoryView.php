<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistoryView extends Model
{
    use HasFactory;

    // Beritahu model ini untuk menggunakan view 'v_order_history'
    protected $table = 'v_order_history';

    // Beritahu Laravel untuk tidak mengelola timestamps untuk view ini
    public $timestamps = false;

    // Ubah kolom tanggal menjadi objek Carbon agar mudah diformat
    protected $casts = [
        'order_date' => 'datetime',
    ];
}