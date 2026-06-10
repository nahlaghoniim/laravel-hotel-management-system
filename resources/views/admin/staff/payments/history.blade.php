@extends('layout')

@section('title', $staff->full_name . ' — Payment History')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Payment History</div>
        <div class="page-title-sub">{{ $staff->full_name }} · {{ $staff->department->name ?? '—' }}</div>
    </div>
    <div style="display:flex; gap:0.6rem; flex-wrap:wrap;">
        <a href="{{ route('staff.payments.index') }}" class="btn-muted">
            <i class="fa-solid fa-arrow-left" style="margin-right:5px;"></i> All Payments
        </a>
        <a href="{{ route('staff.payments.create', ['staff_id' => $staff->id]) }}" class="btn-gold">
            <i class="fa-solid fa-plus"></i> Record Payment
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert-gold-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

{{-- ── Staff hero card ── --}}
<div class="panel" style="margin-bottom:1.25rem;">
    <div class="account-hero">
        <div class="guest-avatar" style="width:52px;height:52px;font-size:18px;border:1.5px solid rgba(201,168,76,0.4);">
            {{ $staff->initials }}
        </div>
        <div style="flex:1;">
            <div class="account-hero-title">{{ $staff->full_name }}</div>
            <div class="account-hero-sub">
                {{ $staff->department->name ?? 'No Department' }} &middot;
                {{ ucfirst($staff->salary_type) }} salary &middot;
                ${{ number_format($staff->salary_amount, 2) }}
            </div>
        </div>
        <a href="{{ route('staff.show', $staff) }}" class="btn-muted" style="border-color:rgba(201,168,76,0.3);color:rgba(245,230,200,0.7);">
            <i class="fa-solid fa-user" style="margin-right:5px;"></i> View Profile
        </a>
    </div>

    {{-- KPI row --}}
    <div class="metric-grid" style="padding:1.25rem;">
        <div class="metric-item">
            <div class="metric-label">Total Paid (All Time)</div>
            <div class="metric-value">${{ number_format($totalPaid, 2) }}</div>
        </div>
        <div class="metric-item">
            <div class="metric-label">Paid This Month</div>
            <div class="metric-value">${{ number_format($paidThisMonth, 2) }}</div>
        </div>
        <div class="metric-item">
            <div class="metric-label">Total Records</div>
            <div class="metric-value">{{ $payments->total() }}</div>
        </div>
        <div class="metric-item">
            <div class="metric-label">Salary Rate</div>
            <div class="metric-value">${{ number_format($staff->salary_amount, 2) }}</div>
            <div style="font-size:11px;color:var(--ink-muted);margin-top:3px;">per {{ $staff->salary_type }}</div>
        </div>
    </div>

    {{-- Monthly mini chart (last 6 months) --}}
    @if($monthlyTotals->isNotEmpty())
    <div style="padding:0 1.25rem 1.25rem;">
        <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-muted);margin-bottom:10px;">
            Last 6 Months
        </div>
        <div class="occ-bar-wrap">
            @php $maxVal = $monthlyTotals->max() ?: 1; @endphp
            @foreach($monthlyTotals as $mon => $total)
            <div class="occ-bar-row">
                <div class="occ-bar-label">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $mon)->format('M Y') }}
                </div>
                <div class="occ-bar-track">
                    <div class="occ-bar-fill"
                         style="width:{{ round(($total / $maxVal) * 100) }}%;
                                background:linear-gradient(90deg, var(--ink-mid), var(--gold));">
                    </div>
                </div>
                <div class="occ-bar-pct">${{ number_format($total, 0) }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- ── Filter ── --}}
<form method="GET" action="{{ route('staff.payments.history', $staff) }}">
    <div class="dash-toolbar" style="margin-bottom:1.25rem;">
        <span class="filter-label-tag"><i class="fa-solid fa-filter"></i> Filter</span>
        <div class="filter-group">
            <label>Month</label>
            <input type="month" name="month" value="{{ request('month') }}" class="field-input">
        </div>
        <button type="submit" class="btn-apply" style="margin-left:auto;">Apply</button>
        @if(request('month'))
            <a href="{{ route('staff.payments.history', $staff) }}" class="btn-muted">Clear</a>
        @endif
    </div>
</form>

{{-- ── Payments table ── --}}
<div class="panel">
    <div class="panel-head">
        <div class="panel-head-left">
            <div class="panel-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <div>
                <div class="panel-title">Payment Records</div>
                <div class="panel-sub">{{ $payments->total() }} {{ Str::plural('entry', $payments->total()) }}</div>
            </div>
        </div>
    </div>

    <div class="table-wrap">
        @if($payments->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                <div class="empty-title">No payments recorded</div>
                <div class="empty-sub">Start by recording the first payment for this staff member.</div>
            </div>
        @else
            <table class="hotel-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Period</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Recorded By</th>
                        <th>Notes</th>
                        <th class="cell-actions"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td class="row-num">{{ $payment->id }}</td>
                        <td class="row-date">{{ $payment->period_label }}</td>
                        <td class="row-date">{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td>
                            <span style="font-size:12px;color:var(--ink-light);">
                                {{ $payment->payment_method_label }}
                            </span>
                        </td>
                        <td>
                            <span style="font-family:var(--font-serif);font-size:17px;color:var(--ink);">
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
                        <td>
                            <span class="row-desc" style="max-width:200px;">
                                {{ $payment->notes ?? '—' }}
                            </span>
                        </td>
                        <td class="cell-actions">
                            <div class="action-btns">
                                <a href="{{ route('staff.payments.edit', $payment) }}"
                                   class="action-btn edit" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('staff.payments.destroy', $payment) }}"
                                      onsubmit="return confirm('Delete this payment?')">
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
                        of {{ $payments->total() }} records
                    </span>
                    {{ $payments->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@endsection