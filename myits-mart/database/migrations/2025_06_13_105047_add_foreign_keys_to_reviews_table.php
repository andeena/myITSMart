<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Sekarang kita bangun 'jembatan'-nya di sini
            // Ini akan berhasil karena tabel products dan customers sudah pasti ada
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Perintah untuk membongkar 'jembatan' jika di-rollback
            $table->dropForeign(['product_id']);
            $table->dropForeign(['customer_id']);
        });
    }
};