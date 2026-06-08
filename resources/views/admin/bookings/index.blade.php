@extends('layout')

@section('title', 'Bookings')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Bookings</div>
        <div class="page-title-sub">Recent and upcoming reservations</div>
    </div>
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
        <a href="{{ route('bookings.create') }}" class="btn-gold">
            <i class="fas fa-plus" style="font-size:10px"></i> New Booking
        </a>
        <a href="{{ route('checkins.create') }}" class="btn-gold">
            <i class="fas fa-door-open" style="font-size:10px"></i> Check In Guest
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="metric-grid">
    <div class="metric-item">
        <div class="metric-label">Total Bookings</div>
        <div class="metric-value">{{ number_format($bookingStats['total'] ?? 0) }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Reserved</div>
        <div class="metric-value">{{ number_format($bookingStats['reserved'] ?? 0) }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Checked In</div>
        <div class="metric-value">{{ number_format($bookingStats['checked_in'] ?? 0) }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Pending Payment</div>
        <div class="metric-value">{{ number_format($bookingStats['pending_payment'] ?? 0) }}</div>
    </div>
</div>

<div class="form-panel" style="max-width:none">
    <div class="form-panel-header">
        <div class="form-panel-icon"><i class="fas fa-calendar-check"></i></div>
        <div>
            <div class="form-panel-title">All Bookings</div>
            <div class="form-panel-sub">{{ $bookings->total() }} reservations in the system</div>
        </div>
    </div>

    <div class="table-wrap">
        <table class="hotel-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Stay</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th class="cell-actions"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td><span class="row-num">{{ $bookings->firstItem() + $loop->index }}</span></td>
                        <td>
                            <div class="guest-cell">
                                <div class="guest-avatar">{{ $booking->guest_initials }}</div>
                                <div>
                                    <div class="row-title">{{ $booking->guest_name }}</div>
                                    <div class="row-desc">{{ optional($booking->customer)->email ?? 'No email' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row-title">{{ $booking->room_label }}</div>
                            <div class="row-desc">{{ $booking->room_type_label }}</div>
                        </td>
                        <td>
                            <div class="row-title">{{ $booking->start_date->format('M j') }} - {{ $booking->end_date->format('M j, Y') }}</div>
                            <div class="row-desc">{{ $booking->nights }} night(s)</div>
                        </td>
                        <td class="row-desc">{{ $booking->adults }} adult(s), {{ $booking->children }} child(ren)</td>
                        <td><span class="status-pill {{ $booking->status_class }}">{{ $booking->formatted_status }}</span></td>
                        <td><span class="status-pill {{ $booking->payment_class }}">{{ $booking->formatted_payment }}</span></td>
                        <td>
                            <div class="row-title">{{ $booking->currency ?? 'USD' }} {{ number_format($booking->total_amount, 2) }}</div>
                        </td>
                        <td class="cell-actions">
                            <div class="action-btns">
                                <a href="{{ route('bookings.show', $booking) }}" class="action-btn view" title="View booking">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($booking->can_checkout)
                                    <a href="{{ route('bookings.checkout', ['booking' => $booking->id]) }}" class="action-btn edit" title="Checkout guest">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </a>
                                @elseif($booking->can_check_in)
                                    <a href="{{ route('checkins.create', ['booking_id' => $booking->id]) }}" class="action-btn edit" title="Check in guest">
                                        <i class="fas fa-door-open"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-calendar-times"></i></div>
                                <div class="empty-title">No bookings yet</div>
                                <div class="empty-sub">Reservations will appear here once they are created.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-actions" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <div class="results-summary">
            @if($bookings->total())
                Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} reservations
            @else
                No bookings found.
            @endif
        </div>
{{ $bookings->links('pagination::bootstrap-4') }}    </div>
</div>
@endsection
