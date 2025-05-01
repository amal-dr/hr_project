<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $primaryKey = 'matricul_manager';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'matricul_manager',
        'apartment_id',
        'first_name',
        'last_name',
        'email',
        'passwordM',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }
    public function getAuthPassword()
    {
        return $this->passwordM;
    }

   

    public function employees()
    {
        return $this->hasMany(Employer::class, 'apartment_id', 'apartment_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'matricul_manager');
    }
}