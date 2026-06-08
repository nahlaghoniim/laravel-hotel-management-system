@extends('layout')
@section('title', 'Edit Room Type')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Edit Room Type</div>
        <div class="page-title-sub">Update the details for <strong style="color:#c9a84c;font-weight:500">{{ $roomtype->title }}</strong></div>
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

@if (session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="form-panel">
    <div class="form-panel-header">
        <div class="form-panel-icon">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <div class="form-panel-title">Update Room Type</div>
            <div class="form-panel-sub">Modify the fields below and save your changes</div>
        </div>
    </div>

    {{-- enctype is required for file uploads --}}
    <form action="{{ route('roomtypes.update', $roomtype->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="field-group">
            <label class="field-label" for="title">Room Type Title</label>
            <input
                type="text"
                id="title"
                name="title"
                class="field-input @error('title') is-invalid @enderror"
                placeholder="e.g. Deluxe Suite, Standard Room..."
                value="{{ old('title', $roomtype->title) }}"
                autofocus
            >
            @error('title')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Price field (required by controller) --}}
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
                value="{{ old('price', $roomtype->price) }}"
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
            >{{ old('description', $roomtype->description) }}</textarea>
            @error('description')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Details field (required by controller) --}}
        <div class="field-group">
            <label class="field-label" for="details">Details</label>
            <textarea
                id="details"
                name="details"
                class="field-input field-textarea @error('details') is-invalid @enderror"
                placeholder="Additional details, policies, inclusions..."
                rows="4"
            >{{ old('details', $roomtype->details) }}</textarea>
            @error('details')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Existing images with delete option --}}
        @if($roomtype->images->count())
        <div class="field-group" style="padding-bottom:1.25rem">
            <label class="field-label">Current Images</label>
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:8px">
                @foreach($roomtype->images as $img)
                <div style="position:relative;width:100px">
                    <img src="{{ $img->url }}" style="width:100px;height:70px;object-fit:cover;border-radius:6px;border:1px solid rgba(201,168,76,0.2)">
                    <label style="display:flex;align-items:center;gap:4px;margin-top:4px;font-size:11px;color:#8b3a2a;cursor:pointer">
                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                        Delete
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- New image uploads --}}
        <div class="field-group">
            <label class="field-label" for="images">Add New Images</label>
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
                Update Room Type
            </button>
        </div>
    </form>
</div>

@endsection