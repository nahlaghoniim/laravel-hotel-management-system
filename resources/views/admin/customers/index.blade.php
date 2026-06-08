@extends('layout')
@section('title', 'Customers')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Customers</div>
        <div class="page-title-sub">Manage all hotel customers</div>
    </div>
    <a href="{{ route('customers.create') }}" class="btn-gold">
        <i class="fas fa-plus" style="font-size:10px"></i> Add Customer
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
                <th style="padding:10px;text-align:left">Full Name</th>
                <th style="padding:10px;text-align:left">Email</th>
                <th style="padding:10px;text-align:left">Phone</th>
                <th style="padding:10px;text-align:left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr style="border-bottom:1px solid rgba(201,168,76,0.1)">
                <td style="padding:10px">{{ $loop->iteration }}</td>
                <td style="padding:10px">
                    @if($customer->photo)
                        <img src="{{ asset('storage/' . $customer->photo) }}"
                             style="width:40px;height:40px;object-fit:cover;border-radius:50%;border:1px solid rgba(201,168,76,0.3)">
                    @else
                        <div style="width:40px;height:40px;border-radius:50%;background:rgba(201,168,76,0.15);display:flex;align-items:center;justify-content:center">
                            <i class="fas fa-user" style="color:#c9a84c"></i>
                        </div>
                    @endif
                </td>
                <td style="padding:10px">{{ $customer->first_name }} {{ $customer->last_name }}</td>
                <td style="padding:10px">{{ $customer->email }}</td>
                <td style="padding:10px">{{ $customer->phone ?? '—' }}</td>
                <td style="padding:10px">
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('customers.show', $customer) }}" class="btn-gold" style="font-size:12px">
                            <i class="fas fa-eye" style="font-size:10px"></i> View
                        </a>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn-gold" style="font-size:12px">
                            <i class="fas fa-edit" style="font-size:10px"></i> Edit
                        </a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                              onsubmit="return confirm('Delete this customer?')">
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
                <td colspan="6" style="padding:20px;text-align:center;color:#888">No customers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection