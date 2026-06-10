<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
     protected $casts = [
        'salary_amount' => 'decimal:2',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
       public function payments(): HasMany
    {
        return $this->hasMany(StaffPayment::class);
    }
 
    /* ── Accessors ── */
 
    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', $this->full_name);
        return strtoupper(
            count($parts) >= 2
                ? $parts[0][0] . $parts[1][0]
                : substr($parts[0], 0, 2)
        );
    }
 
    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->paid()->sum('amount');
    }
 
    public function getTotalPaidThisMonthAttribute(): float
    {
        return (float) $this->payments()
            ->paid()
            ->forMonth(now()->year, now()->month)
            ->sum('amount');
    }
}