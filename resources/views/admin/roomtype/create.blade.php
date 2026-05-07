@extends('layout')

@section('content')

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <h1 class="h3 text-gray-800">
        Add Room Type
    </h1>

    <a href="{{ route('roomtypes.index') }}"
       class="btn btn-secondary btn-sm">

        <i class="fas fa-arrow-left"></i>
        Back to List

    </a>

</div>

<!-- Validation Errors -->
@if ($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<!-- Form Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary">
            Room Type Information
        </h6>

    </div>

    <div class="card-body">

        <form action="{{ route('roomtypes.store') }}"
              method="POST">

            @csrf

            <!-- Room Type Title -->
            <div class="mb-3">

                <label>
                    Room Type Title
                </label>

                <input type="text"
                       name="title"
                       class="form-control"
                       placeholder="Enter room type title"
                       value="{{ old('title') }}">

            </div>

            <!-- Description -->
            <div class="mb-3">

                <label>
                    Description
                </label>

                <textarea name="description"
                          rows="5"
                          class="form-control"
                          placeholder="Enter room type description">{{ old('description') }}</textarea>

            </div>

            <!-- Submit Button -->
            <div class="text-right">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fas fa-save"></i>
                    Save Room Type

                </button>

            </div>

        </form>

    </div>

</div>

@endsection