<?php

// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'description',
        'status',
        'deadline',
        'matricul_employer',
        'matricul_manager'
        
    ];
    protected $casts = [
        'deadline' => 'date:Y-m-d', // Explicitly cast as date
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Accessor for formatted deadline
    public function getFormattedDeadlineAttribute()
    {
        return $this->deadline ? $this->deadline->format('d/m/Y') : 'N/A';
    }


    public function manager()
    {
        return $this->belongsTo(Manager::class, 'matricul_manager');
    }
}