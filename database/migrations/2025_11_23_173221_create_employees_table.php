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
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nik', 20)->unique(); // NIK, harus unik
            $table->string('name', 100);
            $table->string('photo_url')->nullable();
            $table->string('position', 50);
            $table->string('department', 50);
            $table->enum('contract_status', ['Tetap', 'Kontrak', 'Magang', 'Freelance']);
            $table->date('join_date');
            
            // Detail Pribadi
            $table->string('full_name', 150);
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date');
            $table->string('bank_account', 30)->nullable();
            $table->string('data_ktp', 50)->nullable();
            $table->string('data_bpjs', 100)->nullable();

            // Data Pekerjaan
            $table->string('level', 50)->nullable();
            // $table->decimal('salary', 15, 2)->nullable(); // Sebaiknya simpan gaji sebagai angka
            $table->string('manager', 100)->nullable();

            // Detail Payroll (Simpan sebagai JSON atau di tabel terpisah, untuk sederhana kita gunakan JSON)
            // Strukturnya: { baseSalary: ..., fixedAllowance: ..., bpjsTk: ..., bpjsKs: ..., pph21Rate: ... }
            $table->json('payroll_detail')->nullable();

            // Dokumen (Simpan path atau URI sebagai JSON)
            // Strukturnya: [{ name: "KTP", uri: "#" }, ...]
            $table->json('documents')->nullable();

            $table->timestamps(); // created_at dan updated_at
        });
        
        // Tabel untuk Riwayat Karir (Relasi One-to-Many)
        Schema::create('career_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Foreign Key ke tabel employees
            $table->date('date');
            $table->string('type', 50);
            $table->text('detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_histories');
        Schema::dropIfExists('employees');
    }
};