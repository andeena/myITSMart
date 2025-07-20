<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'reviews';

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    /**
     * Casting tipe data otomatis untuk atribut.
     * @var array
     */
    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Mendapatkan data user yang memberikan ulasan.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');    
    }

    /**
     * Mendapatkan data produk yang diulas.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}