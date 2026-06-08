@extends('layout')

@section('title', 'New Check-in')

@section('content')
@php
    $selectedGuest = $selectedBooking
        ? trim(($selectedBooking->customer->first_name ?? '') . ' ' . ($selectedBooking->customer->last_name ?? ''))
        : null;
    $selectedGuest = $selectedGuest ?: null;
@endphp

<div class="page-header">
    <div>
        <div class="page-title">New Check-in</div>
        <div class="page-title-sub">Confirm arrival, room assignment, and front desk handoff</div>
    </div>
    <a href="{{ route('checkins.index') }}" class="btn-muted">
        <i class="fas fa-arrow-left" style="font-size:10px"></i> Back
    </a>
</div>

@if($errors->any())
<div class="alert-gold-danger">
    <i class="fas fa-exclamation-circle"></i>
    <ul style="margin:0;padding-left:1.25rem">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<div class="content-grid">
    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-door-open"></i></div>
            <div>
                <div class="form-panel-title">Arrival Details</div>
                <div class="form-panel-sub">Create an active check-in record</div>
            </div>
        </div>

        <form action="{{ route('checkins.store') }}" method="POST">
            @csrf

            <div class="field-group">
                <label class="field-label" for="booking_id">Booking</label>
                <select id="booking_id" name="booking_id"
                        class="field-input @error('booking_id') is-invalid @enderror" autofocus>
                    <option value="">Select a reservation</option>
                    @foreach($bookings as $booking)
                        @php
                            $guestName = trim(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?: 'Guest';
                            $roomLabel = $booking->room->room_number ?? ($booking->roomType->title ?? 'Unassigned');
                        @endphp
                        <option value="{{ $booking->id }}"
                                data-room-id="{{ $booking->room_id }}"
                                @selected((int) old('booking_id', optional($selectedBooking)->id) === $booking->id)>
                            #{{ $booking->id }} - {{ $guestName }} - {{ $booking->start_date->format('M j') }} to {{ $booking->end_date->format('M j') }} - {{ $roomLabel }}
                        </option>
                    @endforeach
                </select>
                @error('booking_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label" for="room_id">Room</label>
                    <select id="room_id" name="room_id"
                            class="field-input @error('room_id') is-invalid @enderror">
                        <option value="">Assign a room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                    @selected((int) old('room_id', optional($selectedBooking)->room_id) === $room->id)>
                                Room {{ $room->room_number }} - {{ $room->roomType->title ?? 'Room type pending' }} - {{ $room->price ? '$' . number_format($room->price, 2) : 'No rate' }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="staff_id">Front Desk Staff</label>
                    <select id="staff_id" name="staff_id"
                            class="field-input @error('staff_id') is-invalid @enderror">
                        <option value="">Not assigned</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}" @selected((int) old('staff_id') === $member->id)>
                                {{ $member->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('staff_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="field-group">
                <label class="field-label" for="checked_in_at">Checked In At</label>
                <input type="datetime-local" id="checked_in_at" name="checked_in_at"
                       class="field-input @error('checked_in_at') is-invalid @enderror"
                       value="{{ old('checked_in_at', now()->format('Y-m-d\TH:i')) }}">
                @error('checked_in_at')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="4"
                          class="field-input field-textarea @error('notes') is-invalid @enderror"
                          placeholder="Arrival notes, deposit details, special requests">{{ old('notes') }}</textarea>
                @error('notes')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('checkins.index') }}" class="btn-muted">Cancel</a>
                <button type="submit" class="btn-gold">
                    <i class="fas fa-check" style="font-size:11px"></i> Create Check-in
                </button>
            </div>
        </form>
    </div>

    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-concierge-bell"></i></div>
            <div>
                <div class="form-panel-title">Arrival Snapshot</div>
                <div class="form-panel-sub">Selected booking context</div>
            </div>
        </div>

        @if($selectedBooking)
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-user"></i> Guest</div>
                    <div class="detail-value">{{ $selectedGuest ?? 'Guest' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-bed"></i> Room</div>
                    <div class="detail-value">Room {{ $selectedBooking->room->room_number ?? ($selectedBooking->roomType->title ?? 'Unassigned') }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-calendar"></i> Dates</div>
                    <div class="detail-value">{{ $selectedBooking->start_date->format('M j, Y') }} - {{ $selectedBooking->end_date->format('M j, Y') }}</div>
                </div>
                <div class="detail-row" style="border-bottom:none">
                    <div class="detail-label"><i class="fas fa-circle"></i> Status</div>
                    <div class="detail-value">
                        <span class="status-pill status-{{ str_replace('_', '-', $selectedBooking->status) }}">
                            {{ str_replace('_', ' ', $selectedBooking->status) }}
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="empty-title">Choose a booking</div>
                <div class="empty-sub">Select an eligible reservation to prepare the arrival record.</div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookingSelect = document.getElementById('booking_id');
        const roomSelect = document.getElementById('room_id');

        if (!bookingSelect || !roomSelect) return;

        bookingSelect.addEventListener('change', function () {
            const selectedOption = bookingSelect.options[bookingSelect.selectedIndex];
            const roomId = selectedOption ? selectedOption.getAttribute('data-room-id') : null;

            if (roomId) {
                roomSelect.value = roomId;
            }
        });
    });
</script>
@endsection
