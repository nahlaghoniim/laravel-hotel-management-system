@extends('layout')
@section('title', 'Add Department')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Add Department</div>
        <div class="page-title-sub">Create a new department</div>
    </div>
    <a href="{{ route('departments.index') }}" class="btn-gold">
        <i class="fas fa-arrow-left" style="font-size:10px"></i> Back
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
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf

        <div class="field-group">
            <label class="field-label" for="title">Title</label>
            <input type="text" id="title" name="title"
                   class="field-input @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" autofocus>
            @error('title')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="detail">Detail</label>
            <textarea id="detail" name="detail" rows="4"
                      class="field-input field-textarea @error('detail') is-invalid @enderror">{{ old('detail') }}</textarea>
            @error('detail')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('departments.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Save Department
            </button>
        </div>
    </form>
</div>

@endsection