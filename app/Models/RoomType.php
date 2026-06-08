<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
          'price',
        'details',
    ];
     public function images()
    {
        return $this->hasMany(RoomtypeImage::class)->orderBy('sort_order');
    }

    // First image as cover
    public function coverImage()
    {
        return $this->hasOne(RoomtypeImage::class)->orderBy('sort_order');
    }
}