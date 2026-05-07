@extends('layout')

@section('content')

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <h1 class="h3 text-gray-800">
        Edit Room Type
    </h1>

    <a href="{{ route('roomtypes.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>

</div>

<!-- Form Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Update Room Type Information
        </h6>
    </div>

    <div class="card-body">

        <form action="{{ route('roomtypes.update', $roomtype->id) }}" method="POST">

            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">

                <label class="form-label">
                    Room Type Title
                </label>

                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ $roomtype->title }}"
                       placeholder="Enter room type title">

            </div>

            <!-- Description -->
            <div class="mb-3">

                <label class="form-label">
                    Description
                </label>

                <textarea name="description"
                          rows="5"
                          class="form-control"
                          placeholder="Enter room type description">{{ $roomtype->description }}</textarea>

            </div>

            <!-- Submit Button -->
            <div class="text-end">

                <button type="submit" class="btn btn-primary">

                    <i class="fas fa-save"></i>
                    Update Room Type

                </button>

            </div>

        </form>

    </div>

</div>

@endsection