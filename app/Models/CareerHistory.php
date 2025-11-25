<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'date', 'type', 'detail',
    ];

    // Relasi Many-to-One ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
