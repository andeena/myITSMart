<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'order_logs';

    /**
     * Atribut yang bisa diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'status',
        'notes', // Opsional, jika Anda punya kolom catatan
    ];

    /**
     * Mendefinisikan relasi bahwa satu OrderLog milik satu Order.
     * Ini adalah relasi kebalikan dari hasMany di model Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}