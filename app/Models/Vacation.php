<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $fillable = ['matricul_employer', 'reason', 'start_date', 'end_date', 'status'];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'matricul_employer');
    }
}
