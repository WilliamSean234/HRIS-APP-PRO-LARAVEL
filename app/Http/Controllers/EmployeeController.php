<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * GET: Mengambil semua data karyawan.
     */
    public function index()
    {
        // Mengambil semua karyawan, bersamaan dengan riwayat karir mereka (eager loading)
        $employees = Employee::with('careerHistories')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($employees, 200);
    }

    /**
     * GET: Mengambil detail karyawan berdasarkan ID.
     */
    public function show(string $id)
    {
        // Mencari karyawan berdasarkan ID, jika tidak ada, akan throw 404
        $employee = Employee::with('careerHistories')->findOrFail($id);

        return response()->json($employee, 200);
    }

    /**
     * POST: Menyimpan data karyawan baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'nik' => 'required|string|max:20|unique:employees,nik',
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:50',
            'department' => 'required|string|max:50',
            'contract_status' => [
                'required', 
                Rule::in(['Tetap', 'Kontrak', 'Magang', 'Freelance'])
            ],
            'join_date' => 'required|date',
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|unique:employees,email',
            'birth_date' => 'required|date',
            // Tambahkan validasi untuk field lain sesuai kebutuhan
        ]);

        // 2. Buat Karyawan Baru
        $employee = Employee::create($validatedData);

        // 3. Tambahkan Riwayat Karir Awal (Opsional: anggap data awal adalah "Rekrutmen")
        if ($request->has('careerHistory')) {
             // Jika data awal riwayat karir dikirim bersamaan
             $employee->careerHistories()->createMany($request->careerHistory);
        } else {
             // Jika tidak, buat entri default
             $employee->careerHistories()->create([
                'date' => $employee->join_date,
                'type' => 'Rekrutmen',
                'detail' => 'Bergabung sebagai ' . $employee->position,
            ]);
        }
        
        return response()->json([
            'message' => 'Data karyawan berhasil ditambahkan!',
            'employee' => $employee->load('careerHistories') // Load relasi untuk respon
        ], 201); // Kode 201 Created
    }

    /**
     * PUT/PATCH: Memperbarui data karyawan.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        // 1. Validasi Data
        $validatedData = $request->validate([
            // NIK harus unik, tapi abaikan NIK milik karyawan yang sedang diupdate
            'nik' => [
                'sometimes', // Hanya divalidasi jika ada di request
                'string', 
                'max:20', 
                Rule::unique('employees', 'nik')->ignore($employee->id)
            ],
            'name' => 'sometimes|string|max:100',
            // ... (lanjutkan validasi untuk field lain) ...
            'email' => [
                'sometimes', 
                'email', 
                Rule::unique('employees', 'email')->ignore($employee->id)
            ],
            // ...
        ]);

        // 2. Perbarui Data Karyawan
        $employee->update($validatedData);

        // Jika ada perubahan pada Riwayat Karir, logika update harus dilakukan di endpoint terpisah
        
        return response()->json([
            'message' => 'Data karyawan berhasil diperbarui!',
            'employee' => $employee->load('careerHistories')
        ], 200);
    }

    /**
     * DELETE: Menghapus data karyawan.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        
        // Relasi careerHistories akan otomatis terhapus berkat onDelete('cascade') di migration
        $employee->delete();

        return response()->json([
            'message' => 'Data karyawan berhasil dihapus!'
        ], 200);
    }
}