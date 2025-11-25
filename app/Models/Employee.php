<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Field-field yang boleh diisi secara massal
    protected $fillable = [
        'nik', 'name', 'photo_url', 'position', 'department', 'contract_status',
        'join_date', 'full_name', 'email', 'phone', 'address', 'birth_date',
        'bank_account', 'data_ktp', 'data_bpjs', 'level', 'manager',
        'payroll_detail', 'documents'
    ];
    
    // Field yang akan otomatis diubah menjadi tipe data tertentu
    protected $casts = [
        'join_date' => 'date',
        'birth_date' => 'date',
        'payroll_detail' => 'array', // Menyimpan sebagai array/JSON
        'documents' => 'array', // Menyimpan sebagai array/JSON
    ];

    // Relasi One-to-Many ke CareerHistory
    public function careerHistories()
    {
        return $this->hasMany(CareerHistory::class);
    }
    
    // Accessor untuk mengubah format gaji (jika salary disimpan di tabel)
    // public function getSalaryAttribute($value)
    // {
    //     return "Rp " . number_format($value, 0, ',', '.');
    // }
}