@extends('layout')
@section('title', 'Edit Room')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Edit Room</div>
        <div class="page-title-sub">Updating Room <strong style="color:#c9a84c">{{ $room->room_number }}</strong></div>
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
            <div class="form-panel-title">Update Room Information</div>
            <div class="form-panel-sub">Modify the fields below and save your changes</div>
        </div>
    </div>

    <form action="{{ route('rooms.update', $room) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="field-group">
            <label class="field-label" for="room_number">Room Number</label>
            <input type="text" id="room_number" name="room_number"
                   class="field-input @error('room_number') is-invalid @enderror"
                   value="{{ old('room_number', $room->room_number) }}" autofocus>
            @error('room_number')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="room_type_id">Room Type</label>
            <select id="room_type_id" name="room_type_id"
                    class="field-input @error('room_type_id') is-invalid @enderror">
                <option value="">— Select Room Type —</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}"
                        {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
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
                   value="{{ old('price', $room->price) }}" step="0.01" min="0">
            @error('price')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('rooms.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Update Room
            </button>
        </div>
    </form>
</div>

@endsection