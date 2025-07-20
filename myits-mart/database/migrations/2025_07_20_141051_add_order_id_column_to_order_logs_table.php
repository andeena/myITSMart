<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_logs', function (Blueprint $table) {
            // Tambahkan kolom foreign key untuk order_id setelah kolom id
            $table->foreignId('order_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_logs', function (Blueprint $table) {
            // Hapus foreign key dan kolomnya jika di-rollback
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }
};