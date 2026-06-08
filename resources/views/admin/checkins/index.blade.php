@extends('layout')

@section('title', 'Check-ins')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Check-ins</div>
        <div class="page-title-sub">Active and recent guest arrivals</div>
    </div>
    <a href="{{ route('checkins.create') }}" class="btn-gold">
        <i class="fas fa-plus" style="font-size:10px"></i> New Check-in
    </a>
</div>

@if(session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="metric-grid">
    <div class="metric-item">
        <div class="metric-label">Active Check-ins</div>
        <div class="metric-value">{{ number_format($checkinStats['active'] ?? 0) }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Today</div>
        <div class="metric-value">{{ number_format($checkinStats['today'] ?? 0) }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Completed</div>
        <div class="metric-value">{{ number_format($checkinStats['completed'] ?? 0) }}</div>
    </div>
</div>

<div class="form-panel" style="max-width:none">
    <div class="form-panel-header">
        <div class="form-panel-icon"><i class="fas fa-door-open"></i></div>
        <div>
            <div class="form-panel-title">Recent Check-ins</div>
            <div class="form-panel-sub">{{ $checkins->total() }} check-in records</div>
        </div>
    </div>

    <div class="table-wrap">
        <table class="hotel-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Checked In</th>
                    <th>Checked Out</th>
                    <th>Staff</th>
                    <th>Status</th>
                    <th class="cell-actions"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($checkins as $checkin)
                    @php
                        $customer = optional(optional($checkin->booking)->customer);
                        $guestName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: 'Guest';
                        $initials = strtoupper(substr($customer->first_name ?? 'G', 0, 1) . substr($customer->last_name ?? '', 0, 1));
                        $statusClass = 'status-' . str_replace('_', '-', $checkin->status);
                    @endphp
                    <tr>
                        <td><span class="row-num">{{ $checkins->firstItem() + $loop->index }}</span></td>
                        <td>
                            <div class="guest-cell">
                                <div class="guest-avatar">{{ $initials }}</div>
                                <div>
                                    <div class="row-title">{{ $guestName }}</div>
                                    <div class="row-desc">Booking #{{ optional($checkin->booking)->id ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row-title">Room {{ optional($checkin->room)->room_number ?? 'Unassigned' }}</div>
                            <div class="row-desc">{{ optional(optional($checkin->room)->roomType)->title ?? 'Room type pending' }}</div>
                        </td>
                        <td class="row-date">{{ optional($checkin->checked_in_at)->format('M j, Y g:i A') ?? 'Not recorded' }}</td>
                        <td class="row-date">{{ optional($checkin->checked_out_at)->format('M j, Y g:i A') ?? 'In house' }}</td>
                        <td>
                            <div class="row-title">{{ optional($checkin->staff)->full_name ?? 'Not assigned' }}</div>
                        </td>
                        <td><span class="status-pill {{ $statusClass }}">{{ str_replace('_', ' ', $checkin->status) }}</span></td>
                        <td class="cell-actions">
                            @if($checkin->booking)
                                <div class="action-btns">
                                    <a href="{{ route('bookings.show', $checkin->booking) }}" class="action-btn view" title="View booking">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-door-closed"></i></div>
                                <div class="empty-title">No check-ins yet</div>
                                <div class="empty-sub">Guest arrival records will appear here.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-actions">
        {{ $checkins->links() }}
    </div>
</div>
@endsection
