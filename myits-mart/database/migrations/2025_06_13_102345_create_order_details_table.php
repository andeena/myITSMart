<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel order_details.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id(); // Primary Key

            // Foreign Key ke tabel 'orders'. Jika pesanan dihapus, detailnya ikut terhapus.
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // Foreign Key ke tabel 'products'.
            $table->foreignId('product_id')->constrained('products');

            $table->decimal('quantity', 18, 4)->default(1);
            
            // Menyimpan harga satuan saat transaksi, karena harga di tabel products bisa berubah.
            $table->decimal('unit_price', 19, 4); 
            
            $table->double('discount')->default(0);

            // Tabel ini tidak memerlukan timestamps, sesuai desain model kita.
        });
    }

    /**
     * Balikkan migrasi (jika di-rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};