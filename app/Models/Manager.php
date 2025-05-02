<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'matricul_manager';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'matricul_manager',
        'first_name',
        'last_name',
        'email',
        'passwordM',
        'appartment_id',
        'remember_token',
    ];

    protected $hidden = [
        'passwordM',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function appartment()
    {
        return $this->belongsTo(Appartment::class, 'appartment_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'matricul_manager', 'matricul_manager');
    }

    public function vacationRequests()
    {
        return $this->hasMany(VacationRequest::class, 'validated_by_manager', 'matricul_manager');
    }
    // In your Manager model
public function getAuthIdentifierName()
{
    return 'matricul_manager';
}

public function getAuthIdentifier()
{
    return $this->matricul_manager;
}
public function getAuthPassword()
{
    return $this->passwordM;
}
}