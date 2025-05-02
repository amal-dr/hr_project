<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'matricul_employer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'matricul_employer',
        'nom',
        'prenom',
        'email',
        'telephone',
        'passwordE',
        'role',
        'date_embauche',
        'post',
        'appartment_id',
    ];

    protected $hidden = [
        'passwordE',
        'remember_token',
    ];

    public function appartment()
    {
        return $this->belongsTo(Appartment::class, 'appartment_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'matricul_employer', 'matricul_employer');
    }

    public function vacationRequests()
    {
        return $this->hasMany(VacationRequest::class, 'matricul_employer', 'matricul_employer');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'matricul_employer', 'matricul_employer');
    }
}