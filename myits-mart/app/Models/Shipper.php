<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;
    
    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'shippers';

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'company_name',
        'phone',
    ];

    /**
     * Mendapatkan semua pesanan yang dikirim oleh shipper ini.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}