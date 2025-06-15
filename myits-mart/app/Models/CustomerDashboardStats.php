<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDashboardStats extends Model
{
    use HasFactory;

    /**
     * Beritahu model ini untuk terhubung ke database view 'v_customer_dashboard_stats'.
     *
     * @var string
     */
    protected $table = 'v_customer_dashboard_stats';

    /**
     * Beritahu Laravel bahwa primary key untuk view ini adalah 'customer_id'.
     * Ini penting agar kita bisa menggunakan fungsi seperti `find()`.
     *
     * @var string
     */
    protected $primaryKey = 'customer_id';

    /**
     * Beritahu Laravel untuk tidak mengelola kolom created_at dan updated_at.
     *
     * @var bool
     */
    public $timestamps = false;
}
