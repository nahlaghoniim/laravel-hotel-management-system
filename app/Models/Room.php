<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_OCCUPIED = 'occupied';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_OUT_OF_SERVICE = 'out_of_service';
    public const STATUS_MAINTENANCE = 'maintenance';
    public const STATUS_CLEANING = 'cleaning';

    protected $fillable = [
        'room_number',
        'room_type_id',
        'price',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_OCCUPIED => 'Occupied',
            self::STATUS_RESERVED => 'Reserved',
            self::STATUS_OUT_OF_SERVICE => 'Out of Service',
            self::STATUS_MAINTENANCE => 'Maintenance',
            self::STATUS_CLEANING => 'Cleaning',
        ];
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function getStatusLabelAttribute()
    {
        return self::statuses()[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }
}