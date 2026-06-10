@extends('layout')

@section('title', 'Staff Payments')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Staff Payments</div>
        <div class="page-title-sub">All recorded salary & wage payments</div>
    </div>
    <div style="display:flex; gap:0.6rem; flex-wrap:wrap;">
        <a href="{{ route('staff.payments.summary') }}" class="btn-muted">
            <i class="fa-solid fa-chart-pie" style="margin-right:5px;"></i> Summary
        </a>
        <a href="{{ route('staff.payments.create') }}" class="btn-gold">
            <i class="fa-solid fa-plus"></i> Record Payment
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert-gold-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

{{-- ── Filters ── --}}
<form method="GET" action="{{ route('staff.payments.index') }}">
    <div class="dash-toolbar" style="margin-bottom:1.5rem;">
        <span class="filter-label-tag"><i class="fa-solid fa-filter"></i> Filter</span>

        <div class="filter-group">
            <label>Staff Member</label>
            <select name="staff_id" class="field-input" style="min-width:160px;">
                <option value="">All Staff</option>
                @foreach($staffList as $s)
                    <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-divider"></div>

        <div class="filter-group">
            <label>Month</label>
            <input type="month" name="month" value="{{ request('month') }}" class="field-input">
        </div>

        <div class="filter-divider"></div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status" class="field-input">
                <option value="">All</option>
                <option value="paid"      {{ request('status') === 'paid'      ? 'selected' : '' }}>Paid</option>
                <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="filter-divider"></div>

        <div class="filter-group">
            <label>Method</label>
            <select name="method" class="field-input">
                <option value="">All</option>
                <option value="cash"          {{ request('method') === 'cash'          ? 'selected' : '' }}>Cash</option>
                <option value="bank_transfer" {{ request('method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="cheque"        {{ request('method') === 'cheque'        ? 'selected' : '' }}>Cheque</option>
                <option value="other"         {{ request('method') === 'other'         ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <button type="submit" class="btn-apply" style="margin-left:auto;">Apply</button>
        @if(request()->hasAny(['staff_id','month','status','method']))
            <a href="{{ route('staff.payments.index') }}" class="btn-muted">Clear</a>
        @endif
    </div>
</form>

{{-- ── Total strip ── --}}
@if($totalPaid > 0)
<div style="margin-bottom:1.25rem;">
    <div class="alert-chip" style="display:inline-flex; gap:10px; padding:0.75rem 1.25rem; background:#fff; border:1px solid rgba(201,168,76,0.2); border-radius:8px;">
        <span class="alert-chip-dot info"></span>
        <span style="font-size:12px; color:var(--ink-light);">Total paid (current filter):</span>
        <span style="font-family:var(--font-serif); font-size:20px; color:var(--ink);">
            ${{ number_format($totalPaid, 2) }}
        </span>
    </div>
</div>
@endif

{{-- ── Table ── --}}
<div class="panel">
    <div class="panel-head">
        <div class="panel-head-left">
            <div class="panel-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
            <div>
                <div class="panel-title">Payment Records</div>
                <div class="panel-sub">{{ $payments->total() }} {{ Str::plural('record', $payments->total()) }}</div>
            </div>
        </div>
    </div>

    <div class="table-wrap">
        @if($payments->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                <div class="empty-title">No payments found</div>
                <div class="empty-sub">Try adjusting your filters or record a new payment.</div>
            </div>
        @else
            <table class="hotel-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff Member</th>
                        <th>Period</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Recorded By</th>
                        <th class="cell-actions"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td class="row-num">{{ $payment->id }}</td>

                        <td>
                            <div class="guest-cell">
                                <div class="guest-avatar">{{ $payment->staff->initials }}</div>
                                <div>
                                    <div class="row-title">{{ $payment->staff->full_name }}</div>
                                    <div class="row-desc">{{ $payment->staff->department->name ?? '—' }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="row-date">{{ $payment->period_label }}</td>

                        <td class="row-date">{{ $payment->payment_date->format('M d, Y') }}</td>

                        <td>
                            <span style="font-size:12px; color:var(--ink-light);">
                                @if($payment->payment_method === 'cash')
                                    <i class="fa-solid fa-money-bill" style="color:var(--gold);"></i>
                                @elseif($payment->payment_method === 'bank_transfer')
                                    <i class="fa-solid fa-building-columns" style="color:var(--blue);"></i>
                                @elseif($payment->payment_method === 'cheque')
                                    <i class="fa-solid fa-file-lines" style="color:var(--ink-light);"></i>
                                @else
                                    <i class="fa-solid fa-circle-dot" style="color:var(--ink-muted);"></i>
                                @endif
                                {{ $payment->payment_method_label }}
                            </span>
                        </td>

                        <td>
                            <span style="font-family:var(--font-serif); font-size:17px; color:var(--ink);">
                                ${{ number_format($payment->amount, 2) }}
                            </span>
                        </td>

                        <td>
                            <span class="status-pill
                                {{ $payment->status === 'paid'      ? 'status-paid'      : '' }}
                                {{ $payment->status === 'pending'   ? 'status-pending'   : '' }}
                                {{ $payment->status === 'cancelled' ? 'status-cancelled' : '' }}
                            ">{{ $payment->status_label }}</span>
                        </td>

                        <td class="row-date">{{ $payment->paidBy->name ?? '—' }}</td>

                        <td class="cell-actions">
                            <div class="action-btns">
                                <a href="{{ route('staff.payments.history', $payment->staff_id) }}"
                                   class="action-btn view" title="View History">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </a>
                                <a href="{{ route('staff.payments.edit', $payment) }}"
                                   class="action-btn edit" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('staff.payments.destroy', $payment) }}"
                                      onsubmit="return confirm('Delete this payment record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($payments->hasPages())
                <div class="form-actions">
                    <span class="results-summary">
                        Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }}
                        of {{ $payments->total() }} payments
                    </span>
                    {{ $payments->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@endsection