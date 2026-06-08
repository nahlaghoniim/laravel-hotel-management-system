@extends('layout')
@section('title', 'Add Staff')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Add Staff Member</div>
        <div class="page-title-sub">Fill in the details below</div>
    </div>
    <a href="{{ route('staff.index') }}" class="btn-gold">
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
    <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field-group">
            <label class="field-label" for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name"
                   class="field-input @error('full_name') is-invalid @enderror"
                   value="{{ old('full_name') }}" autofocus>
            @error('full_name')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="department_id">Department</label>
            <select id="department_id" name="department_id"
                    class="field-input @error('department_id') is-invalid @enderror">
                <option value="">— Select Department —</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->title }}
                    </option>
                @endforeach
            </select>
            @error('department_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="photo">Photo</label>
            <input type="file" id="photo" name="photo"
                   class="field-input @error('photo') is-invalid @enderror"
                   accept="image/jpg,image/jpeg,image/png,image/webp">
            <div style="font-size:11px;color:#888;margin-top:4px">Accepted: jpg, jpeg, png, webp — max 2MB</div>
            @error('photo')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="bio">Bio</label>
            <textarea id="bio" name="bio" rows="4"
                      class="field-input field-textarea @error('bio') is-invalid @enderror">{{ old('bio') }}</textarea>
            @error('bio')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="salary_type">Salary Type</label>
            <select id="salary_type" name="salary_type"
                    class="field-input @error('salary_type') is-invalid @enderror">
                <option value="">— Select Type —</option>
                <option value="daily"   {{ old('salary_type') == 'daily'   ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ old('salary_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
            @error('salary_type')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="salary_amount">Salary Amount</label>
            <input type="number" id="salary_amount" name="salary_amount"
                   class="field-input @error('salary_amount') is-invalid @enderror"
                   step="0.01" min="0" value="{{ old('salary_amount') }}">
            @error('salary_amount')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('staff.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Save Staff Member
            </button>
        </div>
    </form>
</div>

@endsection