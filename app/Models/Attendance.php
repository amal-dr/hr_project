<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricul_employer',
        'date',
        'arrival_time',
        'leave_time',  // Changed from departure_time
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'arrival_time' => 'datetime:H:i:s',
        'leave_time' => 'datetime:H:i:s',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'matricul_employer', 'matricul_employer');
    }
}