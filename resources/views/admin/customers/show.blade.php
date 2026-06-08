@extends('layout')
@section('title', 'Customer Details')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Customer Details</div>
        <div class="page-title-sub">Viewing <strong style="color:#c9a84c">{{ $customer->first_name }} {{ $customer->last_name }}</strong></div>
    </div>
    <div style="display:flex;gap:0.5rem">
        <a href="{{ route('customers.edit', $customer) }}" class="btn-gold">
            <i class="fas fa-edit" style="font-size:10px"></i> Edit
        </a>
        <form action="{{ route('customers.destroy', $customer) }}" method="POST"
              onsubmit="return confirm('Delete this customer?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger-outline">
                <i class="fas fa-trash" style="font-size:10px"></i> Delete
            </button>
        </form>
        <a href="{{ route('customers.index') }}" class="btn-gold">
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
            @if($customer->photo)
                <img src="{{ asset('storage/' . $customer->photo) }}"
                     style="width:48px;height:48px;object-fit:cover;border-radius:50%">
            @else
                <i class="fas fa-user"></i>
            @endif
        </div>
        <div>
            <div class="form-panel-title">{{ $customer->first_name }} {{ $customer->last_name }}</div>
            <div class="form-panel-sub">Customer since {{ $customer->created_at->format('M Y') }}</div>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-tag"></i> First Name</div>
            <div class="detail-value">{{ $customer->first_name }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-tag"></i> Last Name</div>
            <div class="detail-value">{{ $customer->last_name }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-envelope"></i> Email</div>
            <div class="detail-value">{{ $customer->email }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-phone"></i> Phone</div>
            <div class="detail-value">{{ $customer->phone ?? '—' }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-map-marker-alt"></i> Address</div>
            <div class="detail-value">{{ $customer->address ?? '—' }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label"><i class="fas fa-calendar-plus"></i> Created</div>
            <div class="detail-value">{{ $customer->created_at->format('d M Y, h:i A') }}</div>
        </div>
        <div class="detail-row" style="border-bottom:none">
            <div class="detail-label"><i class="fas fa-clock"></i> Last Updated</div>
            <div class="detail-value">{{ $customer->updated_at->format('d M Y, h:i A') }}</div>
        </div>
    </div>
</div>

@endsection