<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel wishlists.
     */
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();

            // INI ADALAH KOLOM KUNCI YANG KEMUNGKINAN HILANG ATAU SALAH
            // Pastikan kolom ini ada dan terhubung ke tabel customers
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};