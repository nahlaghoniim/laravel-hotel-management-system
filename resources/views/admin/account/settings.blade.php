@extends('layout')

@section('title', 'Settings')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Settings</div>
        <div class="page-title-sub">Security and account preferences</div>
    </div>
    <a href="{{ route('admin.profile') }}" class="btn-gold">
        <i class="fas fa-user" style="font-size:10px"></i> My Profile
    </a>
</div>

@if(session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert-gold-danger">
    <i class="fas fa-exclamation-circle"></i>
    <ul style="margin:0;padding-left:1.25rem">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<div class="content-grid">
    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-lock"></i></div>
            <div>
                <div class="form-panel-title">Password Security</div>
                <div class="form-panel-sub">Change the password for {{ $admin->email }}</div>
            </div>
        </div>

        <form action="{{ route('admin.settings.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field-group">
                <label class="field-label" for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                       class="field-input @error('current_password') is-invalid @enderror"
                       autocomplete="current-password">
                @error('current_password')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label" for="password">New Password</label>
                    <input type="password" id="password" name="password"
                           class="field-input @error('password') is-invalid @enderror"
                           autocomplete="new-password">
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="field-input" autocomplete="new-password">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-muted">Cancel</a>
                <button type="submit" class="btn-gold">
                    <i class="fas fa-key" style="font-size:11px"></i> Update Password
                </button>
            </div>
        </form>
    </div>

    <div class="form-panel" style="max-width:none">
        <div class="form-panel-header">
            <div class="form-panel-icon"><i class="fas fa-shield-alt"></i></div>
            <div>
                <div class="form-panel-title">Account Overview</div>
                <div class="form-panel-sub">Current access state for this admin account</div>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-user"></i> Signed In As</div>
                <div class="detail-value">{{ $admin->name ?? 'Administrator' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-envelope"></i> Email</div>
                <div class="detail-value">{{ $admin->email }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-clock"></i> Session</div>
                <div class="detail-value">Protected by the admin guard</div>
            </div>
            <div class="detail-row" style="border-bottom:none">
                <div class="detail-label"><i class="fas fa-user-shield"></i> Access Level</div>
                <div class="detail-value">Full portal administration</div>
            </div>
        </div>
    </div>
</div>
@endsection
