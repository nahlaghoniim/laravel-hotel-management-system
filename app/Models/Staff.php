<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'department_id',
        'full_name',
        'photo',
        'bio',
        'salary_type',
        'salary_amount',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}