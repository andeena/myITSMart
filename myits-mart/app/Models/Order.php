<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'orders';
    
    /**
     * Laravel tidak mengelola timestamps created_at dan updated_at secara otomatis
     * jika hanya ada kolom order_date. Jika tabel Anda memiliki created_at dan updated_at,
     * baris di bawah ini bisa dihapus.
     */
    public $timestamps = false;


    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'shipper_id',
        'order_date',
        'total_amount',
        'ship_address',
        'status',
    ];

    /**
     * Casting tipe data otomatis untuk atribut.
     * @var array
     */
    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Mendapatkan data pelanggan (user) dari pesanan ini.
     * Sesuai asumsi sebelumnya, 'customer_id' di tabel orders merujuk ke 'id' di tabel users.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Mendapatkan data perusahaan pengiriman (shipper) untuk pesanan ini.
     */
    public function shipper()
    {
        return $this->belongsTo(Shipper::class);
    }

    /**
     * Mendapatkan semua item detail dari pesanan ini.
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Mendapatkan semua log histori dari pesanan ini.
     */
    public function logs()
    {
        return $this->hasMany(OrderLog::class)->latest(); // Diurutkan dari yang terbaru
    }
}