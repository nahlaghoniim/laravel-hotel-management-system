@extends('layout')
@section('title', 'Edit Department')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Edit Department</div>
        <div class="page-title-sub">Updating <strong style="color:#c9a84c">{{ $department->title }}</strong></div>
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
    <form action="{{ route('departments.update', $department) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="field-group">
            <label class="field-label" for="title">Title</label>
            <input type="text" id="title" name="title"
                   class="field-input @error('title') is-invalid @enderror"
                   value="{{ old('title', $department->title) }}" autofocus>
            @error('title')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="detail">Detail</label>
            <textarea id="detail" name="detail" rows="4"
                      class="field-input field-textarea @error('detail') is-invalid @enderror">{{ old('detail', $department->detail) }}</textarea>
            @error('detail')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('departments.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Update Department
            </button>
        </div>
    </form>
</div>

@endsection