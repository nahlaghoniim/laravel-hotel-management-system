@extends('layout')
@section('title', 'Edit Staff')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Edit Staff Member</div>
        <div class="page-title-sub">Updating <strong style="color:#c9a84c">{{ $staff->full_name }}</strong></div>
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
    <form action="{{ route('staff.update', $staff) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="field-group">
            <label class="field-label" for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name"
                   class="field-input @error('full_name') is-invalid @enderror"
                   value="{{ old('full_name', $staff->full_name) }}" autofocus>
            @error('full_name')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="department_id">Department</label>
            <select id="department_id" name="department_id"
                    class="field-input @error('department_id') is-invalid @enderror">
                <option value="">— Select Department —</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}"
                        {{ old('department_id', $staff->department_id) == $dept->id ? 'selected' : '' }}>
                        {{ $dept->title }}
                    </option>
                @endforeach
            </select>
            @error('department_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label">Current Photo</label>
            @if($staff->photo)
                <img src="{{ Storage::url($staff->photo) }}"
                     style="width:80px;height:80px;object-fit:cover;border-radius:50%;margin-bottom:8px;border:1px solid rgba(201,168,76,0.3)">
            @else
                <p style="color:#888;font-size:13px">No photo uploaded.</p>
            @endif

            <label class="field-label" for="photo">Replace Photo</label>
            <input type="file" id="photo" name="photo"
                   class="field-input @error('photo') is-invalid @enderror"
                   accept="image/jpg,image/jpeg,image/png,image/webp">
            <div style="font-size:11px;color:#888;margin-top:4px">Leave blank to keep current photo</div>
            @error('photo')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="bio">Bio</label>
            <textarea id="bio" name="bio" rows="4"
                      class="field-input field-textarea @error('bio') is-invalid @enderror">{{ old('bio', $staff->bio) }}</textarea>
            @error('bio')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="salary_type">Salary Type</label>
            <select id="salary_type" name="salary_type"
                    class="field-input @error('salary_type') is-invalid @enderror">
                <option value="">— Select Type —</option>
                <option value="daily"   {{ old('salary_type', $staff->salary_type) == 'daily'   ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ old('salary_type', $staff->salary_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
            @error('salary_type')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="salary_amount">Salary Amount</label>
            <input type="number" id="salary_amount" name="salary_amount"
                   class="field-input @error('salary_amount') is-invalid @enderror"
                   step="0.01" min="0" value="{{ old('salary_amount', $staff->salary_amount) }}">
            @error('salary_amount')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('staff.index') }}" class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fas fa-save" style="font-size:11px"></i> Update Staff Member
            </button>
        </div>
    </form>
</div>

@endsection