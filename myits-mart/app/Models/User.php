<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Mendapatkan data profil customer yang terhubung dengan user.
     * Asumsi: tabel 'customers' memiliki foreign key 'user_id'.
     */
    public function profile()
    {
        // Seorang User memiliki satu Profile
        return $this->hasOne(Profile::class, 'customer_id');
    }
    
    /**
     * Mendapatkan data customer yang terhubung dengan user.
     * Asumsi: tabel 'customers' memiliki foreign key 'user_id'.
     */
    public function customer()
    {
        // Seorang User memiliki satu Customer
        return $this->hasOne(Customer::class);
    }

    /**
     * Mendapatkan semua pesanan (orders) yang dimiliki oleh user.
     * Relasi ini mengasumsikan 'orders.customer_id' merujuk langsung ke 'users.id'.
     * Ini adalah pola umum jika tabel 'customers' hanya sebagai data tambahan.
     */
    public function orders()
    {
        // Seorang User bisa memiliki banyak Order
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Mendapatkan semua ulasan (reviews) yang telah diberikan oleh user.
     * Asumsi: tabel 'reviews' memiliki foreign key 'user_id'.
     */
    public function reviews()
    {
        // Seorang User bisa memberikan banyak Review
        return $this->hasMany(Review::class, 'customer_id');
    }
    
    /**
     * Mendapatkan semua item di keranjang (cart) milik user.
     * Asumsi: tabel 'carts' memiliki foreign key 'user_id'.
     */
    public function cartItems()
    {
        // Seorang User bisa memiliki banyak item di Cart
        return $this->hasMany(Cart::class);
    }

    /**
     * Mendapatkan semua produk yang ada di wishlist user.
     * Ini menggunakan relasi many-to-many melalui tabel 'wishlists'.
     */
    public function wishlistProducts()
    {
        // Relasi User ke Product melalui tabel pivot 'wishlists'
    return $this->belongsToMany(Product::class, 'wishlists', 'customer_id', 'product_id');
    }

    /**
     * Mendapatkan semua notifikasi untuk user.
     * Asumsi: tabel 'user_notifications' memiliki foreign key 'user_id'.
     */
    public function notifications()
    {
        // Seorang User bisa memiliki banyak Notifikasi
        return $this->hasMany(UserNotification::class);
    }

    
}