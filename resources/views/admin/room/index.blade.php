@extends('layout')
@section('title', 'Rooms')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Rooms</div>
        <div class="page-title-sub">Manage all hotel rooms</div>
    </div>
    <a href="{{ route('rooms.create') }}" class="btn-gold">
        <i class="fas fa-plus" style="font-size:10px"></i> Add Room
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
                <th style="padding:10px;text-align:left">Room Number</th>
                <th style="padding:10px;text-align:left">Room Type</th>
                <th style="padding:10px;text-align:left">Price</th>
                <th style="padding:10px;text-align:left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
            <tr style="border-bottom:1px solid rgba(201,168,76,0.1)">
                <td style="padding:10px">{{ $loop->iteration }}</td>
                <td style="padding:10px">{{ $room->room_number }}</td>
                <td style="padding:10px">{{ $room->roomType->title ?? '—' }}</td>
                <td style="padding:10px">${{ number_format($room->price, 2) }}</td>
                <td style="padding:10px">
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('rooms.show', $room) }}" class="btn-gold" style="font-size:12px">
                            <i class="fas fa-eye" style="font-size:10px"></i> View
                        </a>
                        <a href="{{ route('rooms.edit', $room) }}" class="btn-gold" style="font-size:12px">
                            <i class="fas fa-edit" style="font-size:10px"></i> Edit
                        </a>
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST"
                              onsubmit="return confirm('Delete this room?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-outline" style="font-size:12px">
                                <i class="fas fa-trash" style="font-size:10px"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:20px;text-align:center;color:#888">No rooms found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection