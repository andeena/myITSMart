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
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('name', 100)->nullable();
        $table->string('email_address')->nullable()->unique();
        $table->string('mobile_phone', 25)->nullable();
        $table->text('address')->nullable();
        $table->string('password');
        $table->boolean('membership')->default(false);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
