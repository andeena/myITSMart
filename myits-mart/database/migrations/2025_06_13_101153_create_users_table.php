<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel users.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Kolom-kolom standar Laravel
            $table->id(); // Primary Key (bigint, unsigned, auto-increment)
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); // Kolom created_at dan updated_at
            
            // Kolom kustom kita untuk relasi, tapi BELUM dengan foreign key
            // Tipe data disamakan dengan $table->id() dari customers
            $table->unsignedBigInteger('customer_id')->nullable(); 
        });
    }

    /**
     * Balikkan migrasi (jika di-rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};