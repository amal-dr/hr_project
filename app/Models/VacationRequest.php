<?php

// app/Models/VacationRequest.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacationRequest extends Model
{
    protected $fillable = [
        'matricul_employer',
        'start_date',
        'end_date',
        'status',
        'reason'
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'matricul_employer');
    }
}