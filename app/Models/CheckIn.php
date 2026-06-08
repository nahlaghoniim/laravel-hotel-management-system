<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckIn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'room_id',
        'staff_id',
        'checked_in_at',
        'checked_out_at',
        'notes',
        'status',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
