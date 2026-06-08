@extends('layout')
@section('title', 'Room Type Details')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Room Type Details</div>
        <div class="page-title-sub">Viewing details for <strong style="color:#c9a84c;font-weight:500">{{ $roomtype->title }}</strong></div>
    </div>
    <a href="{{ route('roomtypes.index') }}" class="btn-gold">
        <i class="fas fa-arrow-left" style="font-size:10px"></i>
        Back to List
    </a>
</div>

@if (session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="form-panel">
    <div class="form-panel-header">
        <div class="form-panel-icon">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <div class="form-panel-title">{{ $roomtype->title }}</div>
            <div class="form-panel-sub">Created {{ $roomtype->created_at->diffForHumans() }}</div>
        </div>
        <div style="margin-left:auto;display:flex;gap:0.5rem">
            <a href="{{ route('roomtypes.edit', $roomtype->id) }}" class="btn-gold">
                <i class="fas fa-edit" style="font-size:10px"></i> Edit
            </a>
            <form action="{{ route('roomtypes.destroy', $roomtype->id) }}" method="POST"
                  onsubmit="return confirm('Delete this room type? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger-outline">
                    <i class="fas fa-trash" style="font-size:10px"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">

        <div class="detail-row">
            <div class="detail-label">
                <i class="fas fa-tag"></i> Title
            </div>
            <div class="detail-value">{{ $roomtype->title }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                <i class="fas fa-dollar-sign"></i> Price per Night
            </div>
            <div class="detail-value">${{ number_format($roomtype->price, 2) }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                <i class="fas fa-align-left"></i> Description
            </div>
            <div class="detail-value" style="white-space:pre-line">
                {{ $roomtype->description ?? '—' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                <i class="fas fa-info-circle"></i> Details
            </div>
            <div class="detail-value" style="white-space:pre-line">
                {{ $roomtype->details ?? '—' }}
            </div>
        </div>

        @if($roomtype->images->count())
        <div class="detail-row">
            <div class="detail-label">
                <i class="fas fa-images"></i> Images
            </div>
            <div class="detail-value">
                <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:4px">
                    @foreach($roomtype->images as $img)
                    <img
                        src="{{ $img->url }}"
                        style="width:120px;height:80px;object-fit:cover;border-radius:6px;border:1px solid rgba(201,168,76,0.2)"
                    >
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="detail-row">
            <div class="detail-label">
                <i class="fas fa-calendar-plus"></i> Created
            </div>
            <div class="detail-value">{{ $roomtype->created_at->format('d M Y, h:i A') }}</div>
        </div>

        <div class="detail-row" style="border-bottom:none">
            <div class="detail-label">
                <i class="fas fa-clock"></i> Last Updated
            </div>
            <div class="detail-value">{{ $roomtype->updated_at->format('d M Y, h:i A') }}</div>
        </div>

    </div>
</div>

@endsection