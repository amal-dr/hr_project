<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
    ];

    public function managers()
    {
        return $this->hasMany(Manager::class, 'appartment_id', 'id');
    }

    public function employers()
    {
        return $this->hasMany(Employer::class, 'appartment_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'appartment_id', 'id');
    }
}