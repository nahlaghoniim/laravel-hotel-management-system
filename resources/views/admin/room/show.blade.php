@extends('layout')
@section('title', 'Room Details')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Room Details</div>
        <div class="page-title-sub">Viewing Room <strong style="color:#c9a84c">{{ $room->room_number }}</strong></div>
    </div>
    <div style="display:flex;gap:0.5rem">
        <a href="{{ route('rooms.edit', $room) }}" class="btn-gold">
            <i class="fas fa-edit" style="font-size:10px"></i> Edit
        </a>
        <form action="{{ route('rooms.destroy', $room) }}" method="POST"
              onsubmit="return confirm('Delete this room?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger-outline">
                <i class="fas fa-trash" style="font-size:10px"></i> Delete
            </button>
        </form>
        <a href="{{ route('rooms.index') }}" class="btn-gold">
            <i class="fas fa-arrow-left" style="font-size:10px"></i> Back
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="form-panel">
    <div class="form-panel-header">
        <div class="form-panel-icon">
            <i class="fas fa-door-open"></i>
        </div>
        <div>
            <div class="form-panel-title">Room {{ $room->room_number }}</div>
            <div class="form-panel-sub">{{ $room->roomType->title ?? '—' }}</div>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-hashtag"></i> Room Number</div>
            <div class="detail-value">{{ $room->room_number }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-layer-group"></i> Room Type</div>
            <div class="detail-value">{{ $room->roomType->title ?? '—' }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-dollar-sign"></i> Price per Night</div>
            <div class="detail-value">${{ number_format($room->price, 2) }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-calendar-plus"></i> Created</div>
            <div class="detail-value">{{ $room->created_at->format('d M Y, h:i A') }}</div>
        </div>
        <div class="detail-row" style="border-bottom:none">
            <div class="detail-label"><i class="fas fa-clock"></i> Last Updated</div>
            <div class="detail-value">{{ $room->updated_at->format('d M Y, h:i A') }}</div>
        </div>
    </div>
</div>

@endsection