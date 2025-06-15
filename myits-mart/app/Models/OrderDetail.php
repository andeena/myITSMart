<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'order_details';

    /**
     * Nonaktifkan timestamps jika tabel tidak memiliki kolom created_at & updated_at.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price', // Harga produk pada saat checkout
    ];
    
    /**
     * Casting tipe data otomatis untuk atribut.
     * @var array
     */
    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Mendapatkan data pesanan (order) induk dari detail ini.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mendapatkan data produk yang terkait dengan detail ini.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}