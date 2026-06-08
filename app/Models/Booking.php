<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'room_id',
        'room_type_id',
        'start_date',
        'end_date',
        'status',
        'payment_status',
        'total_amount',
        'currency',
        'adults',
        'children',
        'notes',
        'checked_in_at',
        'checked_out_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }

    public function activeCheckIn()
    {
        return $this->hasOne(CheckIn::class)->where('status', 'active')->latestOfMany();
    }

    public function getGuestNameAttribute()
    {
        return trim(($this->customer->first_name ?? '') . ' ' . ($this->customer->last_name ?? '')) ?: 'Guest';
    }

    public function getGuestInitialsAttribute()
    {
        $first = strtoupper(substr($this->customer->first_name ?? 'G', 0, 1));
        $last = strtoupper(substr($this->customer->last_name ?? '', 0, 1));
        return trim($first . $last) ?: 'GD';
    }

    public function getRoomLabelAttribute()
    {
        if ($this->room) {
            return 'Room ' . $this->room->room_number;
        }

        return $this->roomType->title ?? 'Unassigned';
    }

    public function getRoomTypeLabelAttribute()
    {
        return $this->roomType->title ?? 'Room type pending';
    }

    public function getNightsAttribute()
    {
        if (! $this->start_date || ! $this->end_date) {
            return 0;
        }

        return max(1, $this->start_date->diffInDays($this->end_date));
    }

    public function getStatusClassAttribute()
    {
        return 'status-' . str_replace('_', '-', $this->status);
    }

    public function getPaymentClassAttribute()
    {
        return 'status-' . str_replace('_', '-', $this->payment_status);
    }

    public function getFormattedStatusAttribute()
    {
        return str_replace('_', ' ', $this->status);
    }

    public function getFormattedPaymentAttribute()
    {
        return str_replace('_', ' ', $this->payment_status);
    }

    public function getCanCheckInAttribute()
    {
        return ! $this->activeCheckIn && ! in_array($this->status, ['cancelled', 'checked_out'], true);
    }

    public function getCanCheckoutAttribute()
    {
        return $this->activeCheckIn && $this->status === 'checked_in';
    }

    public function getDueAmountAttribute()
    {
        return $this->payment_status === 'paid' ? 0 : $this->total_amount;
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getPaymentStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->payment_status));
    }

    public function checkout(array $data)
    {
        if (! $this->can_checkout) {
            throw new \LogicException('Booking cannot be checked out.');
        }

        $this->update([
            'status' => 'checked_out',
            'payment_status' => $data['payment_status'],
            'checked_out_at' => now(),
        ]);

        if ($this->activeCheckIn) {
            $this->activeCheckIn->update([
                'status' => 'completed',
                'checked_out_at' => now(),
                'notes' => $data['checkout_notes'] ?? $this->activeCheckIn->notes,
            ]);
        }

        if ($this->room) {
            $this->room->update(['status' => Room::STATUS_CLEANING]);
        }

        return $this;
    }
}
