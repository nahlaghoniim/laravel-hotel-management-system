@extends('layout')
@section('title', 'Staff')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Hotel Staff</div>
        <div class="page-title-sub">Manage all staff members</div>
    </div>
    <div style="display:flex;gap:0.6rem;flex-wrap:wrap;">
        <a href="{{ route('staff.payments.summary') }}" class="btn-muted">
            <i class="fas fa-chart-pie" style="font-size:10px;margin-right:4px"></i> Payroll Summary
        </a>
        <a href="{{ route('staff.payments.index') }}" class="btn-muted">
            <i class="fas fa-money-bill-wave" style="font-size:10px;margin-right:4px"></i> All Payments
        </a>
        <a href="{{ route('staff.create') }}" class="btn-gold">
            <i class="fas fa-plus" style="font-size:10px"></i> Add Staff
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert-gold-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="form-panel">

    {{-- ── Quick payroll stats ── --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:0;border-bottom:1px solid rgba(201,168,76,0.12);">
        <div style="padding:1.1rem 1.5rem;border-right:1px solid rgba(201,168,76,0.1);">
            <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-muted);margin-bottom:5px;">Total Staff</div>
            <div style="font-family:var(--font-serif);font-size:26px;color:var(--ink);">{{ $staff->count() }}</div>
        </div>
        <div style="padding:1.1rem 1.5rem;border-right:1px solid rgba(201,168,76,0.1);">
            <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-muted);margin-bottom:5px;">Monthly Staff</div>
            <div style="font-family:var(--font-serif);font-size:26px;color:var(--ink);">{{ $staff->where('salary_type','monthly')->count() }}</div>
        </div>
        <div style="padding:1.1rem 1.5rem;border-right:1px solid rgba(201,168,76,0.1);">
            <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-muted);margin-bottom:5px;">Daily Staff</div>
            <div style="font-family:var(--font-serif);font-size:26px;color:var(--ink);">{{ $staff->where('salary_type','daily')->count() }}</div>
        </div>
        <div style="padding:1.1rem 1.5rem;">
            <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-muted);margin-bottom:5px;">Paid This Month</div>
            <div style="font-family:var(--font-serif);font-size:26px;color:var(--gold);">${{ number_format($totalPaidThisMonth ?? 0, 0) }}</div>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="table-wrap">
        <table class="hotel-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Staff Member</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Paid This Month</th>
                    <th>Last Payment</th>
                    <th class="cell-actions"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                <tr>
                    <td class="row-num">{{ $loop->iteration }}</td>

                    {{-- Photo + Name --}}
                    <td>
                        <div class="guest-cell">
                            @if($member->photo)
                                <img src="{{ Storage::url($member->photo) }}"
                                     style="width:36px;height:36px;object-fit:cover;border-radius:50%;border:1.5px solid rgba(201,168,76,0.25);flex-shrink:0;">
                            @else
                                <div class="guest-avatar">{{ $member->initials }}</div>
                            @endif
                            <div>
                                <div class="row-title">{{ $member->full_name }}</div>
                                <div class="row-desc">{{ ucfirst($member->salary_type) }} staff</div>
                            </div>
                        </div>
                    </td>

                    {{-- Department --}}
                    <td>
                        <span style="font-size:13px;color:var(--ink-light);">
                            {{ $member->department->title ?? '—' }}
                        </span>
                    </td>

                    {{-- Salary --}}
                    <td>
                        <span style="font-family:var(--font-serif);font-size:16px;color:var(--ink);">
                            ${{ number_format($member->salary_amount, 2) }}
                        </span>
                        <span style="font-size:11px;color:var(--ink-muted);margin-left:3px;">
                            / {{ $member->salary_type }}
                        </span>
                    </td>

                    {{-- Paid this month --}}
                    <td>
                        @php $paidMonth = $member->total_paid_this_month; @endphp
                        @if($paidMonth > 0)
                            <span style="font-family:var(--font-serif);font-size:15px;color:var(--green);">
                                ${{ number_format($paidMonth, 2) }}
                            </span>
                        @else
                            <span class="status-pill status-pending" style="font-size:10px;">Unpaid</span>
                        @endif
                    </td>

                    {{-- Last payment date --}}
                    <td class="row-date">
                        @php $last = $member->payments()->latest('payment_date')->first(); @endphp
                        {{ $last ? $last->payment_date->format('M d, Y') : '—' }}
                    </td>

                    {{-- Actions --}}
                    <td class="cell-actions">
                        <div class="action-btns">
                            {{-- Payment history --}}
                            <a href="{{ route('staff.payments.history', $member) }}"
                               class="action-btn view"
                               title="Payment History">
                                <i class="fas fa-clock-rotate-left"></i>
                            </a>

                            {{-- Quick pay --}}
                            <a href="{{ route('staff.payments.create', ['staff_id' => $member->id]) }}"
                               class="action-btn edit"
                               title="Record Payment">
                                <i class="fas fa-money-bill"></i>
                            </a>

                            {{-- Edit staff --}}
                            <a href="{{ route('staff.edit', $member) }}"
                               class="action-btn"
                               style="background:#f0f0f0;color:#555;"
                               title="Edit Staff">
                                <i class="fas fa-pen"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('staff.destroy', $member) }}" method="POST"
                                  onsubmit="return confirm('Delete {{ addslashes($member->full_name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-users"></i></div>
                            <div class="empty-title">No staff found</div>
                            <div class="empty-sub">Add your first staff member to get started.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection