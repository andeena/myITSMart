<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * [PENTING] Accessor untuk menerjemahkan 'product_name' menjadi 'name'.
     * Sekarang Anda bisa memanggil $product->name di view, dan Laravel akan otomatis mengambil dari 'product_name'.
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['product_name'];
    }

    /**
     * [PENTING] Accessor untuk menerjemahkan 'list_price' menjadi 'price'.
     * Sekarang Anda bisa memanggil $product->price di view, dan Laravel akan mengambil dari 'list_price'.
     */
    public function getPriceAttribute(): float
    {
        return $this->attributes['list_price'];
    }

    /**
     * [PENTING] Accessor untuk gambar.
     * Karena tidak ada kolom gambar, kita akan selalu tampilkan placeholder yang dinamis.
     * Ini akan memperbaiki ikon gambar yang rusak.
     */
    public function getImageUrlAttribute(): string
    {
        // Membuat gambar placeholder dari placehold.co dengan nama produk
        return 'https://placehold.co/600x400/0A6EBD/white?text=' . urlencode($this->product_name);
    }
    
    /**
     * Accessor untuk mendapatkan harga dalam format Rupiah.
     * Ini akan otomatis menggunakan getPriceAttribute() di atas.
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->price, 0, ',', '.'),
        );
    }

    /**
     * Relasi ke ulasan produk.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Accessor untuk mendapatkan rata-rata rating.
     */
    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reviews()->avg('rating') ?? 0,
        );
    }
}
