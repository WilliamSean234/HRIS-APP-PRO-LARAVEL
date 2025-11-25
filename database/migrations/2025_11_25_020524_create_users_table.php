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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // --- TAMBAHKAN KOLOM INI ---
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // --- END KOLOM TAMBAHAN ---
            $table->timestamps();
        });
        
        // Pastikan Anda juga memiliki migrasi untuk password reset tokens (jika belum ada)
        // Schema::create('password_reset_tokens', function (Blueprint $table) { /* ... */ });
        // dan personal access tokens (Sanctum)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};