@extends('layout')
@section('title', 'Add Room Type')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Add Room Type</div>
        <div class="page-title-sub">Create a new room category for your property</div>
    </div>
    <a href="{{ route('roomtypes.index') }}" class="btn-gold">
        <i class="fas fa-arrow-left" style="font-size:10px"></i>
        Back to List
    </a>
</div>

@if ($errors->any())
<div class="alert-gold-danger">
    <i class="fas fa-exclamation-circle"></i>
    <ul style="margin:0;padding-left:1.25rem">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-panel">
    <div class="form-panel-header">
        <div class="form-panel-icon">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <div class="form-panel-title">Room Type Information</div>
            <div class="form-panel-sub">Fill in the details below to add a new room type</div>
        </div>
    </div>

    <form action="{{ route('roomtypes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field-group">
            <label class="field-label" for="title">Room Type Title</label>
            <input
                type="text"
                id="title"
                name="title"
                class="field-input @error('title') is-invalid @enderror"
                placeholder="e.g. Deluxe Suite, Standard Room..."
                value="{{ old('title') }}"
                autofocus
            >
            @error('title')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="price">Price per Night</label>
            <input
                type="number"
                id="price"
                name="price"
                class="field-input @error('price') is-invalid @enderror"
                placeholder="0.00"
                step="0.01"
                min="0"
                value="{{ old('price') }}"
            >
            @error('price')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="description">Description</label>
            <textarea
                id="description"
                name="description"
                class="field-input field-textarea @error('description') is-invalid @enderror"
                placeholder="Describe the features and amenities of this room type..."
                rows="5"
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="details">Details</label>
            <textarea
                id="details"
                name="details"
                class="field-input field-textarea @error('details') is-invalid @enderror"
                placeholder="Additional details, policies, inclusions..."
                rows="4"
            >{{ old('details') }}</textarea>
            @error('details')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="images">Images</label>
            <input
                type="file"
                id="images"
                name="images[]"
                class="field-input @error('images') is-invalid @enderror"
                accept="image/jpg,image/jpeg,image/png,image/webp"
                multiple
            >
            <div style="font-size:11px;color:#888;margin-top:4px">Accepted: jpg, jpeg, png, webp — max 2MB each</div>
            @error('images')
                <div class="field-error">{{ $message }}</div>
            @enderror
            @error('images.*')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('roomtypes.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i>
                Save Room Type
            </button>
        </div>
    </form>
</div>

@endsection