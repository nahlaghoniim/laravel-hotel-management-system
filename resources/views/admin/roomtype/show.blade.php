@extends('layout')

@section('content')

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <h1 class="h3 text-gray-800">
        Room Type Details
    </h1>

    <a href="{{ route('roomtypes.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>

</div>

<!-- Details Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Room Type Information
        </h6>
    </div>

    <div class="card-body">

        <!-- Title -->
        <div class="mb-3">

            <label class="font-weight-bold text-gray-800">
                Title
            </label>

            <p class="form-control bg-light">
                {{ $roomtype->title }}
            </p>

        </div>

        <!-- Description -->
        <div class="mb-3">

            <label class="font-weight-bold text-gray-800">
                Description
            </label>

            <p class="form-control bg-light" style="min-height: 100px;">
                {{ $roomtype->description ?? 'No description available' }}
            </p>

        </div>

    </div>

</div>

@endsection