<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomtypeImage extends Model
{
    protected $fillable = ['roomtype_id', 'image_path', 'sort_order'];

    public function roomtype()
    {
        return $this->belongsTo(RoomType::class);
    }

    // Helper to get full URL
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}