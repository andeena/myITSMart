<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'carts';

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Casting tipe data otomatis untuk atribut.
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Mendapatkan data user pemilik item keranjang ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan data produk dari item keranjang ini.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}