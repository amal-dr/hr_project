<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appartment extends Model
{
    protected $fillable = ['name', 'matricul_manager'];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'matricul_manager');
    }
}