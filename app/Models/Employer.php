<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The authentication guard for this model
     */
    protected $guard = 'employer';

    /**
     * The table associated with the model
     */
    protected $table = 'employers';

    /**
     * The primary key for the model
     */
    protected $primaryKey = 'matricul_employer';

    /**
     * Indicates if the IDs are auto-incrementing
     */
    public $incrementing = false;

    /**
     * The data type of the primary key
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'matricul_employer',
        'passwordE',
        'first_name',
        'last_name',
        'email',
        'department',
        'position',
        // add other fillable fields here
    ];

    /**
     * The attributes that should be hidden for arrays
     */
    protected $hidden = [
        'passwordE',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the password for the user
     */
    public function getAuthPassword()
    {
        return $this->passwordE;
    }

    /**
     * Relationship with Task model
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'matricul_employer', 'matricul_employer');
    }

    /**
     * Relationship with Attendance model
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'matricul_employer', 'matricul_employer');
    }

    /**
     * Relationship with VacationRequest model
     */
    public function vacationRequests()
    {
        return $this->hasMany(VacationRequest::class, 'matricul_employer', 'matricul_employer');
    }

    /**
     * Get the full name of the employer
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}