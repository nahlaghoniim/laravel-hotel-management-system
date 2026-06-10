@extends('layout')

@section('title', 'Add Booking')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Add Booking</div>
        <div class="page-title-sub">Create a new reservation from the admin panel</div>
    </div>
    <a href="{{ route('bookings.index') }}" class="btn-gold">
        <i class="fas fa-arrow-left" style="font-size:10px"></i> Back to Bookings
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

<div class="form-panel">
    <div class="form-panel-header">
        <div class="form-panel-icon"><i class="fas fa-calendar-plus"></i></div>
        <div>
            <div class="form-panel-title">New Reservation</div>
            <div class="form-panel-sub">Add booking details and assign a room.</div>
        </div>
    </div>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <div class="field-group">
            <label class="field-label" for="customer_id">Customer</label>
            <select id="customer_id" name="customer_id" class="field-input @error('customer_id') is-invalid @enderror">
                <option value="">Select customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }} - {{ $customer->email ?? 'No email' }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="room_type_id">Room Type</label>
            <select id="room_type_id" name="room_type_id" class="field-input @error('room_type_id') is-invalid @enderror">
                <option value="">Select room type</option>
                @foreach($roomTypes as $roomType)
                    <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                        {{ $roomType->title }}
                    </option>
                @endforeach
            </select>
            @error('room_type_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="room_id">Room (optional)</label>
            <div id="availability-status" style="margin-bottom:0.75rem;font-size:0.9rem;display:none;padding:0.75rem;border-radius:4px;" class="alert-info"></div>
            <select id="room_id" name="room_id" class="field-input @error('room_id') is-invalid @enderror">
                <option value="">Select available room</option>
                @foreach($availableRooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->room_number }} ({{ $room->roomType->title ?? 'No type' }})
                    </option>
                @endforeach
            </select>
            @error('room_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="field-input @error('start_date') is-invalid @enderror">
            @error('start_date')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="field-input @error('end_date') is-invalid @enderror">
            @error('end_date')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="adults">Adults</label>
            <input type="number" id="adults" name="adults" min="1" value="{{ old('adults', 1) }}" class="field-input @error('adults') is-invalid @enderror">
            @error('adults')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="children">Children</label>
            <input type="number" id="children" name="children" min="0" value="{{ old('children', 0) }}" class="field-input @error('children') is-invalid @enderror">
            @error('children')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="total_amount">Total Amount</label>
            <input type="number" step="0.01" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" class="field-input @error('total_amount') is-invalid @enderror">
            @error('total_amount')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="currency">Currency</label>
            <input type="text" id="currency" name="currency" value="{{ old('currency', 'USD') }}" class="field-input @error('currency') is-invalid @enderror">
            @error('currency')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="payment_status">Payment Status</label>
            <select id="payment_status" name="payment_status" class="field-input @error('payment_status') is-invalid @enderror">
                <option value="pending" {{ old('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ old('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="refunded" {{ old('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
            @error('payment_status')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="notes">Notes</label>
            <textarea id="notes" name="notes" rows="4" class="field-input field-textarea @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
            @error('notes')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('bookings.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Create Booking
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roomTypeSelect = document.getElementById('room_type_id');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const roomSelect = document.getElementById('room_id');
    const statusDiv = document.getElementById('availability-status');

    function checkAvailability() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        const roomTypeId = roomTypeSelect.value;

        if (!startDate || !endDate || !roomTypeId) {
            statusDiv.style.display = 'none';
            return;
        }

        // Show loading status
        statusDiv.style.display = 'block';
        statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking availability...';
        statusDiv.className = 'alert-info';

        fetch('{{ route("bookings.checkAvailability") }}?start_date=' + startDate + '&end_date=' + endDate + '&room_type_id=' + roomTypeId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.count > 0) {
                        statusDiv.innerHTML = '<i class="fas fa-check-circle"></i> <strong>' + data.count + '</strong> room(s) available for selected dates';
                        statusDiv.className = 'alert-success';
                        // Update room options
                        updateRoomOptions(data.rooms);
                    } else {
                        statusDiv.innerHTML = '<i class="fas fa-times-circle"></i> No rooms available for these dates';
                        statusDiv.className = 'alert-warning';
                        roomSelect.innerHTML = '<option value="">No rooms available</option>';
                    }
                } else {
                    statusDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Error checking availability';
                    statusDiv.className = 'alert-danger';
                }
            })
            .catch(error => {
                statusDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Error: ' + error.message;
                statusDiv.className = 'alert-danger';
                console.error('Availability check error:', error);
            });
    }

    function updateRoomOptions(rooms) {
        const currentSelection = roomSelect.value;
        roomSelect.innerHTML = '<option value="">Select available room</option>';
        
        rooms.forEach(room => {
            const option = document.createElement('option');
            option.value = room.id;
            option.textContent = 'Room ' + room.room_number;
            if (currentSelection == room.id) option.selected = true;
            roomSelect.appendChild(option);
        });
    }

    roomTypeSelect.addEventListener('change', checkAvailability);
    startDateInput.addEventListener('change', checkAvailability);
    endDateInput.addEventListener('change', checkAvailability);
});
</script>

<style>
.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
@endsection
