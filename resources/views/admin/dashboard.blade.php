@extends('layout')

@section('title', 'Dashboard')

@section('extra_css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endsection

@section('content')

{{-- ── Page Header ── --}}
<div class="dash-header">
    <div class="dash-header-left">
        <span class="dash-eyebrow">Management Portal</span>
        <div class="dash-title">Good {{ date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') }}, {{ explode(' ', Auth::guard('admin')->user()->name ?? 'Admin')[0] }}</div>
        <div class="dash-subtitle">Here's what's happening at Grand Horizon today</div>
    </div>
    <a href="{{ route('admin.dashboard.report') }}" class="btn-gold">
        <i class="fas fa-download" style="font-size:10px"></i>
        Generate Report
    </a>
</div>

{{-- ── Date Filter Toolbar ── --}}
<div class="dash-toolbar">
    <span class="filter-label-tag"><i class="fas fa-filter" style="font-size:9px;margin-right:4px"></i>Filter</span>
    <form method="GET" style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;flex:1">
        <div class="filter-group">
            <label for="filter">Date Range</label>
            <select name="filter" id="filter" onchange="toggleCustomRange(this.value)">
                <option value="today"      {{ ($filter ?? 'today') === 'today'      ? 'selected' : '' }}>Today</option>
                <option value="this_week"  {{ ($filter ?? '') === 'this_week'       ? 'selected' : '' }}>This Week</option>
                <option value="this_month" {{ ($filter ?? '') === 'this_month'      ? 'selected' : '' }}>This Month</option>
                <option value="custom"     {{ ($filter ?? '') === 'custom'          ? 'selected' : '' }}>Custom Range</option>
            </select>
        </div>

        <div class="filter-divider"></div>

        <div id="custom-range-group" style="display:{{ ($filter ?? 'today') === 'custom' ? 'flex' : 'none' }};gap:1rem;flex-wrap:wrap">
            <div class="filter-group">
                <label for="start">From</label>
                <input type="date" id="start" name="start" value="{{ request('start', $periodStart->format('Y-m-d')) }}">
            </div>
            <div class="filter-group">
                <label for="end">To</label>
                <input type="date" id="end" name="end" value="{{ request('end', $periodEnd->format('Y-m-d')) }}">
            </div>
            <div class="filter-divider"></div>
        </div>

        <button type="submit" class="btn-apply">Apply</button>
        <div class="filter-summary-text">Showing <strong>{{ $periodLabel ?? 'Today' }}</strong></div>
    </form>
</div>

{{-- ══════════════════════════════════════════
     SECTION 1 — Live Occupancy & Revenue
════════════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-text">Live Occupancy</span>
    <div class="section-label-line"></div>
</div>

<div class="kpi-grid" style="margin-bottom:1.25rem">
    {{-- Highlighted Revenue Card --}}
    <div class="kpi-card kpi-highlight" style="grid-row: span 1">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-dollar-sign"></i></div>
            <div class="kpi-label" style="text-align:left;color:rgba(245,230,200,0.45)">
                @if(($filter ?? 'today') === 'today') Today @else Period @endif
            </div>
        </div>
        <div class="rev-row">
            <span class="rev-currency">$</span>
            <span class="rev-big">{{ number_format($periodRevenue ?? $todaysRevenue ?? 0, 0) }}</span>
        </div>
        <div class="rev-label">Confirmed Revenue</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-bed"></i></div>
            <div class="kpi-label">Occupied<br>Rooms</div>
        </div>
        <div class="kpi-value">{{ number_format($occupiedRooms ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> of {{ number_format($roomCount ?? 0) }} total</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-door-open"></i></div>
            <div class="kpi-label">Available<br>Rooms</div>
        </div>
        <div class="kpi-value">{{ number_format($availableRooms ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> ready to assign</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-chart-line"></i></div>
            <div class="kpi-label">Occupancy<br>Rate</div>
        </div>
        <div class="kpi-value">{{ number_format($occupancyRate ?? 0, 1) }}<span style="font-size:18px;color:var(--ink-muted)">%</span></div>
        <div class="kpi-note"><i class="fas fa-circle"></i> based on active stays</div>
    </div>
</div>

{{-- Room Status Row --}}
<div class="kpi-grid" style="margin-bottom:2rem">
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-clock"></i></div>
            <div class="kpi-label">Reserved</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($reservedRooms ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> awaiting arrival</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-tools"></i></div>
            <div class="kpi-label">Maintenance</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($maintenanceRooms ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> repairs in progress</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-broom"></i></div>
            <div class="kpi-label">Cleaning</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($cleaningRooms ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> awaiting servicing</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-ban"></i></div>
            <div class="kpi-label">Out of Service</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($outOfServiceRooms ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> unavailable</div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     SECTION 2 — Today at a Glance + Quick Actions
════════════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-text">Today at a Glance</span>
    <div class="section-label-line"></div>
</div>

<div class="alert-strip" style="margin-bottom:1.25rem">
    <div class="alert-chip">
        <div class="alert-chip-dot info"></div>
        <div>
            <div class="alert-chip-count">{{ number_format($arrivalsToday ?? 0) }}</div>
            <div class="alert-chip-desc">Arrivals today</div>
        </div>
    </div>
    <div class="alert-chip">
        <div class="alert-chip-dot warning"></div>
        <div>
            <div class="alert-chip-count">{{ number_format($checkoutToday ?? 0) }}</div>
            <div class="alert-chip-desc">Check-outs today</div>
        </div>
    </div>
    <div class="alert-chip">
        <div class="alert-chip-dot danger"></div>
        <div>
            <div class="alert-chip-count">{{ number_format($overduePayments ?? 0) }}</div>
            <div class="alert-chip-desc">Overdue payments</div>
        </div>
    </div>
    <div class="alert-chip">
        <div class="alert-chip-dot neutral"></div>
        <div>
            <div class="alert-chip-count">{{ number_format($maintenanceAlerts ?? 0) }}</div>
            <div class="alert-chip-desc">Maintenance alerts</div>
        </div>
    </div>
</div>

<div class="quick-grid" style="margin-bottom:2rem">
    <a href="{{ route('rooms.create') }}" class="quick-pill">
        <i class="fas fa-plus"></i> Add Room
    </a>
    <a href="{{ route('roomtypes.create') }}" class="quick-pill">
        <i class="fas fa-layer-group"></i> Add Room Type
    </a>
    <a href="{{ route('customers.create') }}" class="quick-pill">
        <i class="fas fa-user-plus"></i> Add Customer
    </a>
    <a href="{{ route('bookings.index') }}" class="quick-pill">
        <i class="fas fa-calendar-check"></i> View Bookings
    </a>
    <a href="{{ route('checkins.index') }}" class="quick-pill">
        <i class="fas fa-door-open"></i> View Check-ins
    </a>
    <a href="{{ route('checkins.create') }}" class="quick-pill">
        <i class="fas fa-sign-in-alt"></i> Check In Guest
    </a>
</div>

{{-- ══════════════════════════════════════════
     SECTION 3 — Performance KPIs
════════════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-text">Performance Metrics</span>
    <div class="section-label-line"></div>
</div>

<div class="kpi-grid" style="margin-bottom:1.25rem">
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="kpi-label">ADR</div>
        </div>
        <div class="kpi-value kpi-value-sm">${{ number_format($averageDailyRate ?? 0, 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> average daily rate</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-chart-area"></i></div>
            <div class="kpi-label">RevPAR</div>
        </div>
        <div class="kpi-value kpi-value-sm">${{ number_format($revpar ?? 0, 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> per available room</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
            <div class="kpi-label">Checked-in<br>Guests</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($checkedInCount ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> currently in house</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-sign-out-alt"></i></div>
            <div class="kpi-label">Checked-out<br>Today</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($checkedOutToday ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> departures</div>
    </div>
</div>

<div class="kpi-grid" style="margin-bottom:2rem">
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-plane-arrival"></i></div>
            <div class="kpi-label">Arrivals<br>Next 7 Days</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($arrivals->count() ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> upcoming reservations</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-plane-departure"></i></div>
            <div class="kpi-label">Departures<br>Next 7 Days</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($departures->count() ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> expected check-outs</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
            <div class="kpi-label">Room Types</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($roomTypeCount ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> active categories</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
            <div class="kpi-label">Customers</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($customerCount ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> total profiles</div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     SECTION 4 — Arrivals & Recent Check-ins
════════════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-text">Guests & Arrivals</span>
    <div class="section-label-line"></div>
</div>

<div class="content-row" style="margin-bottom:2rem">

    {{-- Upcoming Arrivals --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-plane-arrival"></i></div>
                <div>
                    <div class="panel-title">Upcoming Arrivals</div>
                    <div class="panel-sub">Next 7 days</div>
                </div>
            </div>
            <span class="panel-badge">{{ $arrivals->count() }} guests</span>
        </div>
        <div class="activity-list">
            @forelse($arrivals as $booking)
            <div class="activity-row">
                <div class="activity-guest">
                    <div class="guest-avatar">
                        {{ strtoupper(substr(optional($booking->customer)->first_name ?? 'G', 0, 1) . substr(optional($booking->customer)->last_name ?? '', 0, 1)) }}
                    </div>
                    <div>
                        <div class="activity-name">{{ trim((optional($booking->customer)->first_name ?? '') . ' ' . (optional($booking->customer)->last_name ?? '')) ?: 'Guest' }}</div>
                        <div class="activity-room">{{ $booking->room->room_number ?? ($booking->roomType->title ?? 'Unassigned') }}</div>
                    </div>
                </div>
                <div class="activity-dates-span">{{ $booking->start_date->format('M j') }} – {{ $booking->end_date->format('M j') }}</div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-calendar-plus"></i></div>
                <div class="empty-title">No upcoming arrivals</div>
                <div class="empty-sub">No new reservations in the next 7 days.</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Check-ins --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-door-open"></i></div>
                <div>
                    <div class="panel-title">Recent Check-ins</div>
                    <div class="panel-sub">Latest arrivals</div>
                </div>
            </div>
            <a href="{{ route('checkins.index') }}" class="panel-badge">View all</a>
        </div>
        <div class="activity-list">
            @forelse($recentCheckins as $checkin)
            <div class="activity-row">
                <div class="activity-guest">
                    <div class="guest-avatar">
                        {{ strtoupper(substr(optional($checkin->booking->customer)->first_name ?? '',0,1) . substr(optional($checkin->booking->customer)->last_name ?? '',0,1)) }}
                    </div>
                    <div>
                        <div class="activity-name">{{ trim((optional($checkin->booking->customer)->first_name ?? '') . ' ' . (optional($checkin->booking->customer)->last_name ?? '')) ?: 'Guest' }}</div>
                        <div class="activity-room">Room {{ optional($checkin->room)->room_number ?? 'Unassigned' }}</div>
                    </div>
                </div>
                <div class="activity-date">{{ optional($checkin->checked_in_at)->format('M j, g:i A') ?? '—' }}</div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-door-closed"></i></div>
                <div class="empty-title">No recent check-ins</div>
                <div class="empty-sub">Guest arrivals will appear here once checked in.</div>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     SECTION 5 — Charts
════════════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-text">Analytics</span>
    <div class="section-label-line"></div>
</div>

{{-- Revenue + Occupancy Trend --}}
<div class="content-row" style="margin-bottom:1.25rem">
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-chart-line"></i></div>
                <div>
                    <div class="panel-title">Revenue Overview</div>
                    <div class="panel-sub">Monthly this year</div>
                </div>
            </div>
            <span class="panel-badge">This Year</span>
        </div>
        <div class="panel-body">
            <div class="chart-wrap">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-chart-area"></i></div>
                <div>
                    <div class="panel-title">Occupancy Trend</div>
                    <div class="panel-sub">Last 12 days</div>
                </div>
            </div>
            <span class="panel-badge">12 Days</span>
        </div>
        <div class="panel-body">
            <div class="chart-wrap">
                <canvas id="occupancyChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Doughnuts Row --}}
<div class="content-row row-3" style="margin-bottom:2rem">

    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-layer-group"></i></div>
                <div>
                    <div class="panel-title">Revenue Sources</div>
                    <div class="panel-sub">By room type</div>
                </div>
            </div>
        </div>
        <div class="panel-body chart-with-legend">
            <div class="chart-wrap chart-wrap-sm"><canvas id="sourceChart"></canvas></div>
            <div class="pie-legend">
                @foreach($roomTypeLabels ?? [] as $i => $label)
                <div class="legend-item">
                    <div class="legend-dot" style="background:{{ ['#c9a84c','#3d2a0c','#e8c97a','#d4b35a','#b7882e'][$i % 5] }}"></div>
                    {{ $label }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-calendar-check"></i></div>
                <div>
                    <div class="panel-title">Booking Status</div>
                    <div class="panel-sub">Current mix</div>
                </div>
            </div>
        </div>
        <div class="panel-body chart-with-legend">
            <div class="chart-wrap chart-wrap-sm"><canvas id="statusChart"></canvas></div>
            <div class="pie-legend">
                @foreach($statusLabels ?? [] as $i => $status)
                <div class="legend-item">
                    <div class="legend-dot" style="background:{{ ['#c9a84c','#3d2a0c','#e8c97a','#b7882e','#a07820'][$i % 5] }}"></div>
                    {{ ucfirst($status) }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-bed"></i></div>
                <div>
                    <div class="panel-title">Room Status</div>
                    <div class="panel-sub">Current inventory</div>
                </div>
            </div>
        </div>
        <div class="panel-body chart-with-legend">
            <div class="chart-wrap chart-wrap-sm"><canvas id="roomStatusChart"></canvas></div>
            <div class="pie-legend">
                @foreach($roomStatusLabels ?? [] as $i => $label)
                <div class="legend-item">
                    <div class="legend-dot" style="background:{{ ['#4caf50','#c9a84c','#3d2a0c','#ff8c42','#6c757d','#d9534f'][$i % 6] }}"></div>
                    {{ $label }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     SECTION 6 — Operations & Departures
════════════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-text">Operations</span>
    <div class="section-label-line"></div>
</div>

<div class="content-row" style="margin-bottom:2rem">

    {{-- Scheduled Departures --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-plane-departure"></i></div>
                <div>
                    <div class="panel-title">Scheduled Departures</div>
                    <div class="panel-sub">Next 7 days</div>
                </div>
            </div>
            <span class="panel-badge">{{ $departures->count() }} guests</span>
        </div>
        <div class="activity-list">
            @forelse($departures as $booking)
            <div class="activity-row">
                <div class="activity-guest">
                    <div class="guest-avatar">
                        {{ strtoupper(substr(optional($booking->customer)->first_name ?? 'G', 0, 1) . substr(optional($booking->customer)->last_name ?? '', 0, 1)) }}
                    </div>
                    <div>
                        <div class="activity-name">{{ trim((optional($booking->customer)->first_name ?? '') . ' ' . (optional($booking->customer)->last_name ?? '')) ?: 'Guest' }}</div>
                        <div class="activity-room">{{ $booking->room->room_number ?? ($booking->roomType->title ?? 'Unassigned') }}</div>
                    </div>
                </div>
                <div class="activity-date">{{ $booking->end_date->format('M j') }}</div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="empty-title">No scheduled departures</div>
                <div class="empty-sub">No departures in the next 7 days.</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Operations Progress --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-tasks"></i></div>
                <div>
                    <div class="panel-title">Operations Progress</div>
                    <div class="panel-sub">Active tasks</div>
                </div>
            </div>
            <span class="panel-badge">Live</span>
        </div>
        <div class="panel-body">
            <div class="task-list">
                <div class="task-item">
                    <div class="task-header">
                        <span class="task-name">Room Maintenance</span>
                        <span class="task-pct">20%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:20%;background:linear-gradient(90deg,#8b3a2a,#c05a45)"></div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="task-header">
                        <span class="task-name">Booking System Update</span>
                        <span class="task-pct">40%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:40%;background:linear-gradient(90deg,#a07820,#c9a84c)"></div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="task-header">
                        <span class="task-name">Customer Database</span>
                        <span class="task-pct">60%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:60%"></div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="task-header">
                        <span class="task-name">Staff Onboarding</span>
                        <span class="task-pct">80%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:80%"></div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="task-header">
                        <span class="task-name">Annual Audit</span>
                        <span class="task-pct">Complete</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:100%;background:linear-gradient(90deg,#2e7d4f,#4caf82)"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     SECTION 7 — Admin Totals
════════════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-text">System Overview</span>
    <div class="section-label-line"></div>
</div>

<div class="kpi-grid" style="margin-bottom:2rem">
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
            <div class="kpi-label">Room Types</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($roomTypeCount ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> active categories</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
            <div class="kpi-label">Customers</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($customerCount ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> total profiles</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-building"></i></div>
            <div class="kpi-label">Departments</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($departmentCount ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> active teams</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon"><i class="fas fa-id-badge"></i></div>
            <div class="kpi-label">Staff</div>
        </div>
        <div class="kpi-value kpi-value-sm">{{ number_format($staffCount ?? 0) }}</div>
        <div class="kpi-note"><i class="fas fa-circle"></i> team members</div>
    </div>
</div>

@endsection

@section('extra_js')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
// ── Shared chart defaults ──
Chart.defaults.global.defaultFontFamily = "'DM Sans', sans-serif";
Chart.defaults.global.defaultFontColor  = '#888070';

const gridColor  = 'rgba(201,168,76,0.08)';
const gold       = '#c9a84c';
const inkDark    = '#3d2a0c';

// ── Revenue Line Chart ──
new Chart(document.getElementById('revenueChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($monthlyRevenue ?? array_fill(0,12,0)) !!},
            borderColor: gold,
            backgroundColor: 'rgba(201,168,76,0.07)',
            borderWidth: 2,
            pointBackgroundColor: gold,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            xAxes: [{ gridLines: { display: false }, ticks: { fontSize: 11 } }],
            yAxes: [{ gridLines: { color: gridColor }, ticks: { fontSize: 11, callback: v => '$' + v.toLocaleString() } }]
        }
    }
});

// ── Occupancy Trend ──
new Chart(document.getElementById('occupancyChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode($occupancyTrendLabels ?? []) !!},
        datasets: [{
            label: 'Active Rooms',
            data: {!! json_encode($occupancyTrendData ?? []) !!},
            borderColor: inkDark,
            backgroundColor: 'rgba(61,42,12,0.07)',
            borderWidth: 2,
            pointRadius: 3,
            pointBackgroundColor: inkDark,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            tension: 0.35,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            xAxes: [{ gridLines: { display: false }, ticks: { fontSize: 11 } }],
            yAxes: [{ gridLines: { color: gridColor }, ticks: { fontSize: 11 } }]
        }
    }
});

// ── Shared doughnut options ──
const doughnutOpts = {
    responsive: true,
    maintainAspectRatio: false,
    cutoutPercentage: 74,
    plugins: { legend: { display: false } },
    animation: { animateRotate: true, animateScale: true }
};

const palette1 = ['#c9a84c','#3d2a0c','#e8c97a','#d4b35a','#b7882e'];
const palette2 = ['#c9a84c','#3d2a0c','#e8c97a','#b7882e','#a07820'];
const palette3 = ['#4caf50','#c9a84c','#3d2a0c','#ff8c42','#6c757d','#d9534f'];

// Revenue by Room Type
new Chart(document.getElementById('sourceChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($roomTypeLabels ?? []) !!},
        datasets: [{ data: {!! json_encode($roomTypeData ?? []) !!}, backgroundColor: palette1, borderWidth: 0, hoverOffset: 8 }]
    },
    options: doughnutOpts
});

// Booking Status
new Chart(document.getElementById('statusChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($statusLabels ?? []) !!},
        datasets: [{ data: {!! json_encode($statusData ?? []) !!}, backgroundColor: palette2, borderWidth: 0, hoverOffset: 8 }]
    },
    options: doughnutOpts
});

// Room Status
new Chart(document.getElementById('roomStatusChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($roomStatusLabels ?? []) !!},
        datasets: [{ data: {!! json_encode($roomStatusData ?? []) !!}, backgroundColor: palette3, borderWidth: 0, hoverOffset: 8 }]
    },
    options: doughnutOpts
});

// ── Custom range toggle ──
function toggleCustomRange(value) {
    document.getElementById('custom-range-group').style.display =
        value === 'custom' ? 'flex' : 'none';
}
</script>
@endsection