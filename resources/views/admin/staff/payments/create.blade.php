@extends('layout')

@section('title', isset($payment) ? 'Edit Payment' : 'Record Payment')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">{{ isset($payment) ? 'Edit Payment' : 'Record Payment' }}</div>
        <div class="page-title-sub">
            {{ isset($payment)
                ? 'Update payment #' . $payment->id . ' for ' . $payment->staff->full_name
                : 'Log a salary or wage payment for a staff member' }}
        </div>
    </div>
    <a href="{{ isset($payment) ? route('staff.payments.history', $payment->staff_id) : route('staff.payments.index') }}"
       class="btn-muted">
        <i class="fa-solid fa-arrow-left" style="margin-right:5px;"></i> Back
    </a>
</div>

@if($errors->any())
    <div class="alert-gold-danger">
        <i class="fa-solid fa-circle-exclamation"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul style="margin:4px 0 0 16px; padding:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form method="POST"
      action="{{ isset($payment) ? route('staff.payments.update', $payment) : route('staff.payments.store') }}">
    @csrf
    @if(isset($payment)) @method('PUT') @endif

    <div class="form-panel">

        <div class="form-panel-header">
            <div class="form-panel-icon">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <div class="form-panel-title">
                    {{ isset($payment) ? 'Edit Payment Record' : 'New Payment Record' }}
                </div>
                <div class="form-panel-sub">All fields marked * are required</div>
            </div>
        </div>

        <div class="form-grid" style="padding:0 1.5rem;">

            {{-- Staff Member --}}
            <div class="field-group grid-full">
                <label class="field-label">Staff Member *</label>
                <select name="staff_id"
                        id="staffSelect"
                        class="field-input {{ $errors->has('staff_id') ? 'is-invalid' : '' }}"
                        onchange="prefillSalary(this)">
                    <option value="">— Select staff member —</option>
                    @foreach($staffList as $s)
                        <option value="{{ $s->id }}"
                                data-salary="{{ $s->salary_amount }}"
                                data-type="{{ $s->salary_type }}"
                                {{ old('staff_id', $payment->staff_id ?? $selectedStaff?->id) == $s->id ? 'selected' : '' }}>
                            {{ $s->full_name }} ({{ ucfirst($s->salary_type) }} — ${{ number_format($s->salary_amount, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('staff_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Amount --}}
            <div class="field-group">
                <label class="field-label">Amount ($) *</label>
                <input type="number"
                       name="amount"
                       id="amountField"
                       step="0.01"
                       min="0.01"
                       value="{{ old('amount', $payment->amount ?? '') }}"
                       placeholder="0.00"
                       class="field-input {{ $errors->has('amount') ? 'is-invalid' : '' }}">
                @error('amount') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            {{-- Payment Date --}}
            <div class="field-group">
                <label class="field-label">Payment Date *</label>
                <input type="date"
                       name="payment_date"
                       value="{{ old('payment_date', isset($payment) ? $payment->payment_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                       class="field-input {{ $errors->has('payment_date') ? 'is-invalid' : '' }}">
                @error('payment_date') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            {{-- Period From --}}
            <div class="field-group">
                <label class="field-label">Period From *</label>
                <input type="date"
                       name="period_from"
                       value="{{ old('period_from', isset($payment) ? $payment->period_from->format('Y-m-d') : now()->startOfMonth()->format('Y-m-d')) }}"
                       class="field-input {{ $errors->has('period_from') ? 'is-invalid' : '' }}">
                @error('period_from') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            {{-- Period To --}}
            <div class="field-group">
                <label class="field-label">Period To *</label>
                <input type="date"
                       name="period_to"
                       value="{{ old('period_to', isset($payment) ? $payment->period_to->format('Y-m-d') : now()->endOfMonth()->format('Y-m-d')) }}"
                       class="field-input {{ $errors->has('period_to') ? 'is-invalid' : '' }}">
                @error('period_to') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            {{-- Payment Method --}}
            <div class="field-group">
                <label class="field-label">Payment Method *</label>
                <select name="payment_method"
                        class="field-input {{ $errors->has('payment_method') ? 'is-invalid' : '' }}">
                    @foreach(['cash' => 'Cash', 'bank_transfer' => 'Bank Transfer', 'cheque' => 'Cheque', 'other' => 'Other'] as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('payment_method', $payment->payment_method ?? 'cash') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            {{-- Status --}}
            <div class="field-group">
                <label class="field-label">Status *</label>
                <select name="status"
                        class="field-input {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    @foreach(['paid' => 'Paid', 'pending' => 'Pending', 'cancelled' => 'Cancelled'] as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('status', $payment->status ?? 'paid') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            {{-- Notes --}}
            <div class="field-group grid-full">
                <label class="field-label">Notes</label>
                <textarea name="notes"
                          rows="3"
                          placeholder="Optional note about this payment…"
                          class="field-input field-textarea {{ $errors->has('notes') ? 'is-invalid' : '' }}"
                >{{ old('notes', $payment->notes ?? '') }}</textarea>
                @error('notes') <div class="field-error">{{ $message }}</div> @enderror
            </div>

        </div><!-- /.form-grid -->

        <div class="form-actions">
            <a href="{{ isset($payment) ? route('staff.payments.history', $payment->staff_id) : route('staff.payments.index') }}"
               class="btn-muted">Cancel</a>
            <button type="submit" class="btn-gold">
                <i class="fa-solid fa-{{ isset($payment) ? 'floppy-disk' : 'plus' }}"></i>
                {{ isset($payment) ? 'Save Changes' : 'Record Payment' }}
            </button>
        </div>

    </div><!-- /.form-panel -->
</form>

@endsection

@push('scripts')
<script>
    // Auto-fill amount from staff salary when staff is selected
    function prefillSalary(select) {
        const opt    = select.options[select.selectedIndex];
        const salary = opt.dataset.salary;
        const field  = document.getElementById('amountField');
        if (salary && !field.value) {
            field.value = parseFloat(salary).toFixed(2);
        }
    }

    // Run on page load in case staff is pre-selected
    document.addEventListener('DOMContentLoaded', function () {
        const sel = document.getElementById('staffSelect');
        if (sel && sel.value && !document.getElementById('amountField').value) {
            prefillSalary(sel);
        }
    });
</script>
@endpush