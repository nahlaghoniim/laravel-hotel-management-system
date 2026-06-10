@extends('layout')

@section('title', 'Payroll Summary')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Payroll Summary</div>
        <div class="page-title-sub">Monthly totals by department and top earners</div>
    </div>
    <div style="display:flex;gap:0.6rem;flex-wrap:wrap;align-items:center;">
        <a href="{{ route('staff.payments.index') }}" class="btn-muted">
            <i class="fa-solid fa-list" style="margin-right:5px;"></i> All Payments
        </a>
        <a href="{{ route('staff.payments.create') }}" class="btn-gold">
            <i class="fa-solid fa-plus"></i> Record Payment
        </a>
    </div>
</div>

{{-- Month filter --}}
<form method="GET" action="{{ route('staff.payments.summary') }}" style="margin-bottom:1.5rem;">
    <div class="dash-toolbar">
        <span class="filter-label-tag"><i class="fa-solid fa-calendar"></i> Period</span>
        <div class="filter-group">
            <label>Month</label>
            <input type="month" name="month" value="{{ $month }}" class="field-input">
        </div>
        <button type="submit" class="btn-apply">View</button>
    </div>
</form>

{{-- ── Grand total KPI ── --}}
<div class="kpi-grid kpi-grid-3" style="margin-bottom:1.5rem;">

    <div class="kpi-card kpi-highlight">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
            <div class="kpi-label">Total Payroll<br>This Month</div>
        </div>
        <div class="kpi-value">${{ number_format($grandTotal, 0) }}</div>
        <div class="kpi-note">
            <i class="fa-solid fa-circle"></i>
            {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fa-solid fa-building"></i></div>
            <div class="kpi-label">Departments<br>With Payments</div>
        </div>
        <div class="kpi-value">{{ $byDepartment->count() }}</div>
        <div class="kpi-note"><i class="fa-solid fa-circle"></i> Active this month</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
            <div class="kpi-label">Top Earner<br>This Month</div>
        </div>
        @if($topEarners->isNotEmpty())
            <div class="kpi-value kpi-value-sm">
                {{ $topEarners->first()->staff->full_name ?? '—' }}
            </div>
            <div class="kpi-note">
                <i class="fa-solid fa-circle"></i>
                ${{ number_format($topEarners->first()->total, 2) }}
            </div>
        @else
            <div class="kpi-value kpi-value-sm">—</div>
        @endif
    </div>

</div>

<div class="content-row">

    {{-- ── By Department ── --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fa-solid fa-building"></i></div>
                <div>
                    <div class="panel-title">By Department</div>
                    <div class="panel-sub">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="panel-body">
            @if($byDepartment->isEmpty())
                <div class="empty-state" style="padding:2rem 1rem;">
                    <div class="empty-icon"><i class="fa-solid fa-building"></i></div>
                    <div class="empty-title">No data</div>
                    <div class="empty-sub">No paid payments for this month.</div>
                </div>
            @else
                @php $maxDept = $byDepartment->max('total') ?: 1; @endphp
                <div class="occ-bar-wrap">
                    @foreach($byDepartment as $row)
                    <div class="occ-bar-row">
                        <div class="occ-bar-label" style="width:120px;">{{ $row->department }}</div>
                        <div class="occ-bar-track">
                            <div class="occ-bar-fill"
                                 style="width:{{ round(($row->total / $maxDept) * 100) }}%;
                                        background:linear-gradient(90deg, var(--ink-mid), var(--gold));">
                            </div>
                        </div>
                        <div class="occ-bar-pct" style="width:70px;">
                            ${{ number_format($row->total, 0) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ── Top Earners ── --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fa-solid fa-ranking-star"></i></div>
                <div>
                    <div class="panel-title">Top Earners</div>
                    <div class="panel-sub">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="activity-list">
            @forelse($topEarners as $i => $entry)
            <div class="activity-row">
                <div class="activity-guest">
                    <div class="guest-avatar">{{ $entry->staff->initials }}</div>
                    <div>
                        <div class="activity-name">{{ $entry->staff->full_name }}</div>
                        <div class="activity-room">{{ $entry->staff->department->name ?? '—' }}</div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="font-family:var(--font-serif);font-size:18px;color:var(--ink);">
                        ${{ number_format($entry->total, 2) }}
                    </div>
                    <a href="{{ route('staff.payments.history', $entry->staff_id) }}"
                       style="font-size:11px;color:var(--gold);text-decoration:none;">
                        View history →
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state" style="padding:2rem 1rem;">
                <div class="empty-icon"><i class="fa-solid fa-ranking-star"></i></div>
                <div class="empty-title">No data</div>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ── Last 6 months trend ── --}}
<div class="panel">
    <div class="panel-head">
        <div class="panel-head-left">
            <div class="panel-icon"><i class="fa-solid fa-chart-line"></i></div>
            <div>
                <div class="panel-title">6-Month Payroll Trend</div>
                <div class="panel-sub">Total paid salaries per month</div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        @if($last6Months->isEmpty())
            <div class="empty-state" style="padding:1.5rem 1rem;">
                <div class="empty-icon"><i class="fa-solid fa-chart-line"></i></div>
                <div class="empty-title">No trend data yet</div>
            </div>
        @else
            @php $maxTrend = $last6Months->max() ?: 1; @endphp
            <div class="occ-bar-wrap">
                @foreach($last6Months as $mon => $total)
                <div class="occ-bar-row">
                    <div class="occ-bar-label" style="width:90px;">
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $mon)->format('M Y') }}
                    </div>
                    <div class="occ-bar-track" style="height:8px;">
                        <div class="occ-bar-fill"
                             style="width:{{ round(($total / $maxTrend) * 100) }}%;
                                    background:linear-gradient(90deg, var(--ink-mid), var(--gold));
                                    height:8px;">
                        </div>
                    </div>
                    <div class="occ-bar-pct" style="width:80px;">
                        ${{ number_format($total, 0) }}
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection