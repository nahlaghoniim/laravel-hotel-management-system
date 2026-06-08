@extends('layout')

@section('title', 'Booking #' . $booking->id)

@section('content')
@php
    $guestName = trim(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?: 'Guest';
    $initials = strtoupper(substr($booking->customer->first_name ?? 'G', 0, 1) . substr($booking->customer->last_name ?? '', 0, 1));
    $roomName = $booking->room->room_number ?? ($booking->roomType->title ?? 'Unassigned');
    $nights = max(1, $booking->start_date->diffInDays($booking->end_date));
    $statusClass = 'status-' . str_replace('_', '-', $booking->status);
    $paymentClass = 'status-' . str_replace('_', '-', $booking->payment_status);
    $canCheckIn = ! $booking->activeCheckIn && ! in_array($booking->status, ['cancelled', 'checked_out'], true);
@endphp

<div class="page-header">
    <div>
        <div class="page-title">Booking #{{ $booking->id }}</div>
        <div class="page-title-sub">Reservation details for {{ $guestName }}</div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        @if($booking->can_checkout)
            <a href="{{ route('bookings.checkout', ['booking' => $booking->id]) }}" class="btn-gold">
                <i class="fas fa-sign-out-alt" style="font-size:10px"></i> Checkout
            </a>
        @elseif($canCheckIn)
            <a href="{{ route('checkins.create', ['booking_id' => $booking->id]) }}" class="btn-gold">
                <i class="fas fa-door-open" style="font-size:10px"></i> Check In
            </a>
        @endif
        <a href="{{ route('bookings.index') }}" class="btn-muted">
            <i class="fas fa-arrow-left" style="font-size:10px"></i> Back
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-gold-danger">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<div class="metric-grid">
    <div class="metric-item">
        <div class="metric-label">Stay Length</div>
        <div class="metric-value">{{ $nights }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Guests</div>
        <div class="metric-value">{{ $booking->adults + $booking->children }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Total</div>
        <div class="metric-value">{{ $booking->currency ?? 'USD' }} {{ number_format($booking->total_amount, 2) }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Payment</div>
        <div><span class="status-pill {{ $paymentClass }}">{{ str_replace('_', ' ', $booking->payment_status) }}</span></div>
    </div>
</div>

<div class="content-grid">
    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-receipt"></i></div>
            <div>
                <div class="form-panel-title">Reservation Summary</div>
                <div class="form-panel-sub">{{ $booking->start_date->format('M j, Y') }} to {{ $booking->end_date->format('M j, Y') }}</div>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-user"></i> Guest</div>
                <div class="detail-value">
                    <div class="guest-cell">
                        <div class="guest-avatar">{{ $initials }}</div>
                        <div>
                            <div class="row-title">{{ $guestName }}</div>
                            <div class="row-desc">{{ optional($booking->customer)->email ?? 'No email' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-bed"></i> Room</div>
                <div class="detail-value">Room {{ $roomName }} <span class="row-desc">({{ $booking->roomType->title ?? 'Room type pending' }})</span></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-calendar"></i> Stay Dates</div>
                <div class="detail-value">{{ $booking->start_date->format('M j, Y') }} - {{ $booking->end_date->format('M j, Y') }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-users"></i> Occupancy</div>
                <div class="detail-value">{{ $booking->adults }} adult(s), {{ $booking->children }} child(ren)</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-circle"></i> Status</div>
                <div class="detail-value"><span class="status-pill {{ $statusClass }}">{{ str_replace('_', ' ', $booking->status) }}</span></div>
            </div>
            <div class="detail-row" style="border-bottom:none">
                <div class="detail-label"><i class="fas fa-sticky-note"></i> Notes</div>
                <div class="detail-value">{{ $booking->notes ?: 'No notes recorded for this booking.' }}</div>
            </div>
        </div>
    </div>

    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-door-open"></i></div>
            <div>
                <div class="form-panel-title">Check-in State</div>
                <div class="form-panel-sub">Front desk handoff</div>
            </div>
        </div>

        @if($booking->activeCheckIn)
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-check"></i> Status</div>
                    <div class="detail-value"><span class="status-pill status-active">active</span></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-clock"></i> Checked In</div>
                    <div class="detail-value">{{ optional($booking->activeCheckIn->checked_in_at)->format('M j, Y g:i A') ?? 'Not recorded' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-user-tie"></i> Staff</div>
                    <div class="detail-value">{{ optional($booking->activeCheckIn->staff)->full_name ?? 'Not assigned' }}</div>
                </div>
                <div class="detail-row" style="border-bottom:none">
                    <div class="detail-label"><i class="fas fa-sticky-note"></i> Notes</div>
                    <div class="detail-value">{{ $booking->activeCheckIn->notes ?: 'No check-in notes.' }}</div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-door-closed"></i></div>
                <div class="empty-title">Not checked in</div>
                <div class="empty-sub">This reservation has no active check-in record.</div>
                @if($canCheckIn)
                    <a href="{{ route('checkins.create', ['booking_id' => $booking->id]) }}" class="btn-gold" style="margin-top:1rem">
                        <i class="fas fa-door-open" style="font-size:10px"></i> Start Check-in
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
