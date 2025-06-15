<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrderHistory extends Model
{
    use HasFactory;

    /**
     * Secara eksplisit memberitahu model ini untuk menggunakan database view 'v_user_order_history'.
     *
     * @var string
     */
    protected $table = 'v_user_order_history';

    /**
     * Database view biasanya tidak memiliki primary key 'id' yang bisa di-increment.
     * Jika view Anda tidak memiliki kolom 'id', baris ini diperlukan.
     * Jika ada, baris ini bisa dihapus atau di-set ke 'id' atau 'order_id'.
     */
    // protected $primaryKey = 'order_id';
    // public $incrementing = false;

    /**
     * Memberitahu Laravel untuk tidak mengelola kolom created_at dan updated_at untuk model ini.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Secara otomatis mengubah tipe data kolom saat diakses.
     * Ini penting agar kita bisa memformat tanggal dengan mudah di view.
     *
     * @var array
     */
    protected $casts = [
        'order_date' => 'datetime',
    ];
}