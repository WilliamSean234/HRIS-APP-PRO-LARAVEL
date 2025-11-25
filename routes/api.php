<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

// Rute untuk mengelola data karyawan
// Route::prefix('employees')->group(function () {
//     // GET: /api/employees - Mengambil semua data karyawan
//     Route::get('/', [EmployeeController::class, 'index']);
    
//     // POST: /api/employees - Menambahkan karyawan baru
//     Route::post('/', [EmployeeController::class, 'store']);
    
//     // GET: /api/employees/{id} - Mengambil detail karyawan
//     Route::get('/{id}', [EmployeeController::class, 'show']);
    
//     // PUT/PATCH: /api/employees/{id} - Memperbarui data karyawan
//     Route::put('/{id}', [EmployeeController::class, 'update']);
    
//     // DELETE: /api/employees/{id} - Menghapus karyawan
//     Route::delete('/{id}', [EmployeeController::class, 'destroy']);
// });

Route::apiResource('employees', EmployeeController::class);