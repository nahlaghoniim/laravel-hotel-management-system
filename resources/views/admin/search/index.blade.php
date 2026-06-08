@extends('layout')

@section('title', 'Search')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Search</div>
        <div class="page-title-sub">
            @if($query)
                {{ $bookings->total() }} booking result(s) for "{{ $query }}"
            @else
                Search bookings, rooms, guests, and reservation status
            @endif
        </div>
    </div>
    <a href="{{ route('bookings.index') }}" class="btn-muted">
        <i class="fas fa-calendar-check" style="font-size:10px"></i> Bookings
    </a>
</div>

<div class="form-panel" style="max-width:none;margin-bottom:1.25rem">
    <form action="{{ route('admin.search') }}" method="GET">
        <div class="form-grid">
            <div class="field-group grid-full">
                <label class="field-label" for="q">Search Term</label>
                <input type="text" id="q" name="q" class="field-input"
                       value="{{ $query }}" placeholder="Guest name, email, room number, status, or booking ID">
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.search') }}" class="btn-muted">Clear</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-search" style="font-size:11px"></i> Search
            </button>
        </div>
    </form>
</div>

<div class="form-panel" style="max-width:none">
    <div class="form-panel-header">
        <div class="form-panel-icon"><i class="fas fa-search"></i></div>
        <div>
            <div class="form-panel-title">Booking Results</div>
            <div class="form-panel-sub">{{ $bookings->total() }} matched reservation(s)</div>
        </div>
    </div>

    <div class="table-wrap">
        <table class="hotel-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Dates</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th class="cell-actions"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    @php
                        $guestName = trim((optional($booking->customer)->first_name ?? '') . ' ' . (optional($booking->customer)->last_name ?? '')) ?: 'Guest';
                        $initials = strtoupper(substr(optional($booking->customer)->first_name ?? 'G', 0, 1) . substr(optional($booking->customer)->last_name ?? '', 0, 1));
                        $roomName = optional($booking->room)->room_number ?? optional($booking->roomType)->title ?? 'Room';
                        $statusClass = 'status-' . str_replace('_', '-', $booking->status);
                        $paymentClass = 'status-' . str_replace('_', '-', $booking->payment_status);
                    @endphp
                    <tr>
                        <td><span class="row-num">{{ $bookings->firstItem() + $loop->index }}</span></td>
                        <td>
                            <div class="guest-cell">
                                <div class="guest-avatar">{{ $initials }}</div>
                                <div>
                                    <div class="row-title">{{ $guestName }}</div>
                                    <div class="row-desc">{{ optional($booking->customer)->email ?? 'No email' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row-title">Room {{ $roomName }}</div>
                            <div class="row-desc">{{ optional($booking->roomType)->title ?? 'Room type pending' }}</div>
                        </td>
                        <td>
                            <div class="row-title">{{ $booking->start_date->format('M j') }} - {{ $booking->end_date->format('M j, Y') }}</div>
                            <div class="row-desc">{{ max(1, $booking->start_date->diffInDays($booking->end_date)) }} night(s)</div>
                        </td>
                        <td><span class="status-pill {{ $statusClass }}">{{ str_replace('_', ' ', $booking->status) }}</span></td>
                        <td><span class="status-pill {{ $paymentClass }}">{{ str_replace('_', ' ', $booking->payment_status) }}</span></td>
                        <td>
                            <div class="row-title">{{ $booking->currency ?? 'USD' }} {{ number_format($booking->total_amount, 2) }}</div>
                        </td>
                        <td class="cell-actions">
                            <div class="action-btns">
                                <a href="{{ route('bookings.show', $booking) }}" class="action-btn view" title="View booking">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-search"></i></div>
                                <div class="empty-title">No results found</div>
                                <div class="empty-sub">Try another guest name, email, room number, or booking status.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-actions">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
