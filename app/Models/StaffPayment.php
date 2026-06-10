<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffPayment extends Model
{
    protected $fillable = [
        'staff_id',
        'paid_by',
        'amount',
        'payment_date',
        'period_from',
        'period_to',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'period_from'  => 'date',
        'period_to'    => 'date',
        'amount'       => 'decimal:2',
    ];

    /* ── Relationships ── */

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    /* ── Scopes ── */

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('payment_date', $year)
                     ->whereMonth('payment_date', $month);
    }

    /* ── Accessors ── */

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash'          => 'Cash',
            'bank_transfer' => 'Bank Transfer',
            'cheque'        => 'Cheque',
            default         => 'Other',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    public function getPeriodLabelAttribute(): string
    {
        return $this->period_from->format('M d') . ' – ' . $this->period_to->format('M d, Y');
    }
}