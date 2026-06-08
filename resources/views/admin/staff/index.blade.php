@extends('layout')
@section('title', 'Staff')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Hotel Staff</div>
        <div class="page-title-sub">Manage all staff members</div>
    </div>
    <a href="{{ route('staff.create') }}" class="btn-gold">
        <i class="fas fa-plus" style="font-size:10px"></i> Add Staff
    </a>
</div>

@if(session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="form-panel">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="border-bottom:1px solid rgba(201,168,76,0.2)">
                <th style="padding:10px;text-align:left">#</th>
                <th style="padding:10px;text-align:left">Photo</th>
                <th style="padding:10px;text-align:left">Name</th>
                <th style="padding:10px;text-align:left">Department</th>
                <th style="padding:10px;text-align:left">Salary</th>
                <th style="padding:10px;text-align:left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staff as $member)
            <tr style="border-bottom:1px solid rgba(201,168,76,0.1)">
                <td style="padding:10px">{{ $loop->iteration }}</td>
                <td style="padding:10px">
                    @if($member->photo)
                        <img src="{{ Storage::url($member->photo) }}"
                             style="width:40px;height:40px;object-fit:cover;border-radius:50%">
                    @else
                        <div style="width:40px;height:40px;border-radius:50%;background:rgba(201,168,76,0.2);display:flex;align-items:center;justify-content:center">
                            <i class="fas fa-user" style="color:#c9a84c"></i>
                        </div>
                    @endif
                </td>
                <td style="padding:10px">{{ $member->full_name }}</td>
                <td style="padding:10px">{{ $member->department->title ?? '—' }}</td>
                <td style="padding:10px">${{ number_format($member->salary_amount, 2) }} / {{ $member->salary_type }}</td>
                <td style="padding:10px;display:flex;gap:6px">
                    <a href="{{ route('staff.edit', $member) }}" class="btn-gold" style="font-size:12px">Edit</a>
                    <form action="{{ route('staff.destroy', $member) }}" method="POST"
                          onsubmit="return confirm('Delete this staff member?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger-outline" style="font-size:12px">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:20px;text-align:center;color:#888">No staff found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection