<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * Kolom yang bisa diisi secara massal.
     * Sesuaikan ini dengan kolom yang ada di tabel 'profiles' Anda.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        // tambahkan kolom lain jika ada
    ];

    /**
     * Mendefinisikan relasi bahwa satu Profile ini dimiliki oleh satu User.
     * Ini adalah relasi kebalikan dari hasOne di model User.
     */
    public function user()
    {
        // Laravel akan mencari foreign key 'user_id' secara otomatis
        return $this->belongsTo(User::class);
    }
}