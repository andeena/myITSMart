<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * [PERBAIKAN] Mendefinisikan kolom mana saja yang boleh diisi
     * secara massal dari form untuk keamanan. Ini akan memperbaiki
     * error MassAssignmentException.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'list_price',
        'stock',
        'product_category',
        'description',
    ];

    /**
     * Accessor untuk menerjemahkan 'product_name' menjadi 'name' agar kompatibel dengan view lama.
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['product_name'];
    }

    /**
     * Accessor untuk menerjemahkan 'list_price' menjadi 'price' agar kompatibel dengan view lama.
     */
    public function getPriceAttribute(): float
    {
        return $this->attributes['list_price'];
    }

    /**
     * Accessor untuk gambar placeholder.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }

        return 'https://placehold.co/600x400/0A6EBD/white?text=' . urlencode($this->product_name);
    }
    
    /**
     * Accessor untuk mendapatkan harga dalam format Rupiah.
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
