@extends('layout')
@section('title', 'Room Types')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Room Types</div>
        <div class="page-title-sub">Manage your property's room categories</div>
    </div>
    <a href="{{ route('roomtypes.create') }}" class="btn-gold">
        <i class="fas fa-plus" style="font-size:10px"></i>
        Add Room Type
    </a>
</div>

@if (session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert-gold-danger">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

<div class="form-panel">
    <div class="form-panel-header">
        <div class="form-panel-icon"><i class="fas fa-layer-group"></i></div>
        <div>
            <div class="form-panel-title">All Room Types</div>
            <div class="form-panel-sub">{{ $roomtypes->count() }} total room types</div>
        </div>
    </div>

    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="border-bottom:1px solid rgba(201,168,76,0.2)">
                    <th style="padding:10px;text-align:left">#</th>
                    <th style="padding:10px;text-align:left">Title</th>
                    <th style="padding:10px;text-align:left">Price</th>
                    <th style="padding:10px;text-align:left">Images</th>
                    <th style="padding:10px;text-align:left">Description</th>
                    <th style="padding:10px;text-align:left">Created</th>
                    <th style="padding:10px;text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roomtypes as $roomtype)
                <tr style="border-bottom:1px solid rgba(201,168,76,0.1)">
                    <td style="padding:10px">{{ $loop->iteration }}</td>
                    <td style="padding:10px">{{ $roomtype->title }}</td>
                    <td style="padding:10px">${{ number_format($roomtype->price, 2) }}</td>
                    <td style="padding:10px">
                        <span class="panel-badge">
                            <i class="fas fa-images"></i>
                            {{ $roomtype->images_count }}
                        </span>
                    </td>
                    <td style="padding:10px;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Str::limit($roomtype->description, 60) ?: '—' }}</td>
                    <td style="padding:10px">{{ $roomtype->created_at->format('d M Y') }}</td>
                    <td style="padding:10px;text-align:right">
                        <div style="display:flex;align-items:center;gap:6px;justify-content:flex-end;flex-wrap:nowrap;">
                            <a href="{{ route('roomtypes.show', $roomtype) }}" class="btn-gold" style="font-size:12px;white-space:nowrap;">
                                <i class="fas fa-eye" style="font-size:10px"></i> View
                            </a>
                            <a href="{{ route('roomtypes.edit', $roomtype) }}" class="btn-gold" style="font-size:12px;white-space:nowrap;">
                                <i class="fas fa-edit" style="font-size:10px"></i> Edit
                            </a>
                            <form action="{{ route('roomtypes.destroy', $roomtype) }}" method="POST" onsubmit="return confirm('Delete this room type?')" style="margin:0;display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger-outline" style="font-size:12px;white-space:nowrap;">
                                    <i class="fas fa-trash" style="font-size:10px"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:20px;text-align:center;color:#888">No room types found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection