<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricul_employer',
        'start_date',
        'end_date',
        'reason',
        'status',
        'validated_by_manager',
        'manager_comment',
        'validated_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'validated_at' => 'datetime',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'matricul_employer', 'matricul_employer');
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'validated_by_manager', 'matricul_manager');
    }
}