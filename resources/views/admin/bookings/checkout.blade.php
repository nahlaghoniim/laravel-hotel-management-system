@extends('layout')

@section('title', 'Checkout Booking #' . $booking->id)

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Checkout Booking #{{ $booking->id }}</div>
        <div class="page-title-sub">Finalize payment and complete the guest departure</div>
    </div>
    <a href="{{ route('bookings.show', $booking) }}" class="btn-muted">
        <i class="fas fa-arrow-left" style="font-size:10px"></i> Back to reservation
    </a>
</div>

@if(session('error'))
<div class="alert-gold-danger">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<div class="metric-grid">
    <div class="metric-item">
        <div class="metric-label">Guest</div>
        <div class="metric-value">{{ $booking->guest_name }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Room</div>
        <div class="metric-value">{{ $booking->room_label }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Stay Total</div>
        <div class="metric-value">{{ $booking->currency ?? 'USD' }} {{ number_format($booking->total_amount, 2) }}</div>
    </div>
    <div class="metric-item">
        <div class="metric-label">Amount Due</div>
        <div class="metric-value">{{ $booking->currency ?? 'USD' }} {{ number_format($booking->due_amount, 2) }}</div>
    </div>
</div>

<div class="content-grid">
    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-receipt"></i></div>
            <div>
                <div class="form-panel-title">Reservation details</div>
                <div class="form-panel-sub">Review the reservation before checkout</div>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-calendar-alt"></i> Stay Dates</div>
                <div class="detail-value">{{ $booking->start_date->format('M j, Y') }} to {{ $booking->end_date->format('M j, Y') }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-users"></i> Occupancy</div>
                <div class="detail-value">{{ $booking->adults }} adult(s), {{ $booking->children }} child(ren)</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-user-check"></i> Check-in time</div>
                <div class="detail-value">{{ optional($booking->activeCheckIn->checked_in_at)->format('M j, Y g:i A') ?? 'Not recorded' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-user-tie"></i> Staff</div>
                <div class="detail-value">{{ optional($booking->activeCheckIn->staff)->full_name ?? 'Not assigned' }}</div>
            </div>
            <div class="detail-row" style="border-bottom:none">
                <div class="detail-label"><i class="fas fa-sticky-note"></i> Notes</div>
                <div class="detail-value">{{ $booking->notes ?: 'No reservation notes.' }}</div>
            </div>
        </div>
    </div>

    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-credit-card"></i></div>
            <div>
                <div class="form-panel-title">Checkout</div>
                <div class="form-panel-sub">Complete payment and move the room to cleaning</div>
            </div>
        </div>

        <form action="{{ route('bookings.checkout.process', $booking) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select id="payment_status" name="payment_status">
                    <option value="paid" {{ old('payment_status', $booking->payment_status) === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ old('payment_status', $booking->payment_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="refunded" {{ old('payment_status', $booking->payment_status) === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
                @error('payment_status')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="checkout_notes">Checkout Notes</label>
                <textarea id="checkout_notes" name="checkout_notes" rows="4">{{ old('checkout_notes') }}</textarea>
                @error('checkout_notes')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions" style="justify-content:flex-end;gap: .75rem;">
                <a href="{{ route('bookings.show', $booking) }}" class="btn-muted">Cancel</a>
                <button type="submit" class="btn-gold">
                    <i class="fas fa-sign-out-alt" style="font-size:10px"></i> Complete Checkout
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
