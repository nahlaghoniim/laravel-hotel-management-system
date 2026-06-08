<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['title', 'detail'];

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}