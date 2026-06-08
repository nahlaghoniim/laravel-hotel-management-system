@extends('layout')
@section('title', 'Add Room')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Add Room</div>
        <div class="page-title-sub">Create a new hotel room</div>
    </div>
    <a href="{{ route('rooms.index') }}" class="btn-gold">
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
        <div class="form-panel-icon"><i class="fas fa-door-open"></i></div>
        <div>
            <div class="form-panel-title">Room Information</div>
            <div class="form-panel-sub">Fill in the details below to add a new room</div>
        </div>
    </div>

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf

        <div class="field-group">
            <label class="field-label" for="room_number">Room Number</label>
            <input type="text" id="room_number" name="room_number"
                   class="field-input @error('room_number') is-invalid @enderror"
                   value="{{ old('room_number') }}" placeholder="e.g. 101, 202..." autofocus>
            @error('room_number')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="room_type_id">Room Type</label>
            <select id="room_type_id" name="room_type_id"
                    class="field-input @error('room_type_id') is-invalid @enderror">
                <option value="">— Select Room Type —</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->title }}
                    </option>
                @endforeach
            </select>
            @error('room_type_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="price">Price per Night</label>
            <input type="number" id="price" name="price"
                   class="field-input @error('price') is-invalid @enderror"
                   value="{{ old('price') }}" placeholder="0.00" step="0.01" min="0">
            @error('price')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('rooms.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Save Room
            </button>
        </div>
    </form>
</div>

@endsection