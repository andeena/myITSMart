<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'customers';

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        // tambahkan kolom lain jika ada, misal: 'city', 'postal_code'
    ];

    /**
     * Mendapatkan data user yang memiliki profil customer ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}