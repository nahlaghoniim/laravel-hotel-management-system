@extends('layout')
@section('title', 'Edit Customer')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Edit Customer</div>
        <div class="page-title-sub">Updating <strong style="color:#c9a84c">{{ $customer->first_name }} {{ $customer->last_name }}</strong></div>
    </div>
    <a href="{{ route('customers.index') }}" class="btn-gold">
        <i class="fas fa-arrow-left" style="font-size:10px"></i> Back to List
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
        <div class="form-panel-icon"><i class="fas fa-user-edit"></i></div>
        <div>
            <div class="form-panel-title">Update Customer Information</div>
            <div class="form-panel-sub">Modify the fields below and save your changes</div>
        </div>
    </div>

    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="field-group">
            <label class="field-label" for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name"
                   class="field-input @error('first_name') is-invalid @enderror"
                   value="{{ old('first_name', $customer->first_name) }}" autofocus>
            @error('first_name')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name"
                   class="field-input @error('last_name') is-invalid @enderror"
                   value="{{ old('last_name', $customer->last_name) }}">
            @error('last_name')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="email">Email Address</label>
            <input type="email" id="email" name="email"
                   class="field-input @error('email') is-invalid @enderror"
                   value="{{ old('email', $customer->email) }}">
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone"
                   class="field-input @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $customer->phone) }}">
            @error('phone')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="address">Address</label>
            <textarea id="address" name="address" rows="3"
                      class="field-input field-textarea @error('address') is-invalid @enderror">{{ old('address', $customer->address) }}</textarea>
            @error('address')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label">Current Photo</label>
            @if($customer->photo)
                <img src="{{ asset('storage/' . $customer->photo) }}"
                     style="width:80px;height:80px;object-fit:cover;border-radius:50%;display:block;margin-bottom:8px;border:1px solid rgba(201,168,76,0.3)">
            @else
                <p style="color:#888;font-size:13px">No photo uploaded.</p>
            @endif

            <label class="field-label" for="photo">Replace Photo</label>
            <input type="file" id="photo" name="photo"
                   class="field-input @error('photo') is-invalid @enderror"
                   accept="image/jpg,image/jpeg,image/png,image/webp">
            <div style="font-size:11px;color:#888;margin-top:4px">Leave blank to keep current photo</div>
            @error('photo')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('customers.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Update Customer
            </button>
        </div>
    </form>
</div>

@endsection