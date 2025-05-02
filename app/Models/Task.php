<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'matricul_employer',
        'matricul_manager',
        'appartment_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'matricul_employer', 'matricul_employer');
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'matricul_manager', 'matricul_manager');
    }

    public function appartment()
    {
        return $this->belongsTo(Appartment::class, 'appartment_id', 'id');
    }
}