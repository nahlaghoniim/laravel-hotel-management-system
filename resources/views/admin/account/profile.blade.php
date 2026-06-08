@extends('layout')

@section('title', 'My Profile')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">My Profile</div>
        <div class="page-title-sub">Manage your administrator identity</div>
    </div>
    <a href="{{ route('admin.settings') }}" class="btn-gold">
        <i class="fas fa-cog" style="font-size:10px"></i> Settings
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
            <div class="form-panel-icon"><i class="fas fa-user-edit"></i></div>
            <div>
                <div class="form-panel-title">Profile Details</div>
                <div class="form-panel-sub">Update the name and email shown across the portal</div>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label" for="name">Display Name</label>
                    <input type="text" id="name" name="name"
                           class="field-input @error('name') is-invalid @enderror"
                           value="{{ old('name', $admin->name) }}" placeholder="Administrator name">
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           class="field-input @error('email') is-invalid @enderror"
                           value="{{ old('email', $admin->email) }}" placeholder="admin@example.com">
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-muted">Cancel</a>
                <button type="submit" class="btn-gold">
                    <i class="fas fa-save" style="font-size:11px"></i> Save Profile
                </button>
            </div>
        </form>
    </div>

    <div class="form-panel" style="max-width:none">
        <div class="account-hero">
            <div class="guest-avatar">
                {{ strtoupper(substr($admin->name ?? 'A', 0, 2)) }}
            </div>
            <div>
                <div class="account-hero-title">{{ $admin->name ?? 'Administrator' }}</div>
                <div class="account-hero-sub">{{ $admin->email }}</div>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-id-badge"></i> Role</div>
                <div class="detail-value">Administrator</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fas fa-calendar"></i> Created</div>
                <div class="detail-value">{{ optional($admin->created_at)->format('M j, Y') ?? 'Not available' }}</div>
            </div>
            <div class="detail-row" style="border-bottom:none">
                <div class="detail-label"><i class="fas fa-clock"></i> Updated</div>
                <div class="detail-value">{{ optional($admin->updated_at)->diffForHumans() ?? 'Not available' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
