@extends('layout')
@section('title', 'Departments')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Departments</div>
        <div class="page-title-sub">Manage all hotel departments</div>
    </div>
    <a href="{{ route('departments.create') }}" class="btn-gold">
        <i class="fas fa-plus" style="font-size:10px"></i> Add Department
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
                <th style="padding:10px;text-align:left">Title</th>
                <th style="padding:10px;text-align:left">Detail</th>
                <th style="padding:10px;text-align:left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $department)
            <tr style="border-bottom:1px solid rgba(201,168,76,0.1)">
                <td style="padding:10px">{{ $loop->iteration }}</td>
                <td style="padding:10px">{{ $department->title }}</td>
                <td style="padding:10px">{{ $department->detail ?? '—' }}</td>
                <td style="padding:10px;display:flex;gap:6px">
                    <a href="{{ route('departments.edit', $department) }}" class="btn-gold" style="font-size:12px">Edit</a>
                    <form action="{{ route('departments.destroy', $department) }}" method="POST"
                          onsubmit="return confirm('Delete this department?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger-outline" style="font-size:12px">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:20px;text-align:center;color:#888">No departments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection