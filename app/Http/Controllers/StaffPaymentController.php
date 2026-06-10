<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffPaymentController extends Controller
{
    /**
     * All payments — filterable by staff, month, status, method.
     */
    public function index(Request $request)
    {
        $query = StaffPayment::with(['staff.department', 'paidBy'])->latest('payment_date');

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->forMonth($year, $month);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        // Calculate total BEFORE paginating
        $totalPaid = (clone $query)->where('status', 'paid')->sum('amount');
        $payments  = $query->paginate(20)->appends($request->query());
        $staffList = Staff::orderBy('full_name')->get();

        return view('admin.staff.payments.index', compact('payments', 'staffList', 'totalPaid'));
    }

    /**
     * Show form to record a new payment.
     * Optionally pre-selects a staff member via ?staff_id=
     */
    public function create(Request $request)
    {
        $staffList     = Staff::orderBy('full_name')->get();
        $selectedStaff = $request->filled('staff_id')
            ? Staff::findOrFail($request->staff_id)
            : null;

        return view('admin.staff.payments.create', compact('staffList', 'selectedStaff'));
    }

    /**
     * Store a new payment record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id'       => 'required|exists:staff,id',
            'amount'         => 'required|numeric|min:0.01',
            'payment_date'   => 'required|date',
            'period_from'    => 'required|date',
            'period_to'      => 'required|date|after_or_equal:period_from',
            'payment_method' => 'required|in:cash,bank_transfer,cheque,other',
            'status'         => 'required|in:paid,pending,cancelled',
            'notes'          => 'nullable|string|max:1000',
        ]);

        StaffPayment::create([
            ...$request->only(
                'staff_id', 'amount', 'payment_date',
                'period_from', 'period_to',
                'payment_method', 'status', 'notes'
            ),
            'paid_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()
            ->route('staff.payments.history', $request->staff_id)
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Payment history for a single staff member.
     */
    public function history(Staff $staff, Request $request)
    {
        $query = $staff->payments()->with('paidBy')->latest('payment_date');

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->forMonth($year, $month);
        }

        $payments      = $query->paginate(15)->appends($request->query());
        $totalPaid     = $staff->payments()->paid()->sum('amount');
        $paidThisMonth = $staff->total_paid_this_month;

        // Monthly breakdown for the bar chart (last 6 months)
        $monthlyTotals = $staff->payments()
            ->paid()
            ->where('payment_date', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('admin.staff.payments.history', compact(
            'staff', 'payments', 'totalPaid', 'paidThisMonth', 'monthlyTotals'
        ));
    }

    /**
     * Edit a payment record.
     */
    public function edit(StaffPayment $payment)
    {
        $staffList = Staff::orderBy('full_name')->get();
        return view('admin.staff.payments.edit', compact('payment', 'staffList'));
    }

    /**
     * Update a payment record.
     */
    public function update(Request $request, StaffPayment $payment)
    {
        $request->validate([
            'staff_id'       => 'required|exists:staff,id',
            'amount'         => 'required|numeric|min:0.01',
            'payment_date'   => 'required|date',
            'period_from'    => 'required|date',
            'period_to'      => 'required|date|after_or_equal:period_from',
            'payment_method' => 'required|in:cash,bank_transfer,cheque,other',
            'status'         => 'required|in:paid,pending,cancelled',
            'notes'          => 'nullable|string|max:1000',
        ]);

        $payment->update($request->only(
            'staff_id', 'amount', 'payment_date',
            'period_from', 'period_to',
            'payment_method', 'status', 'notes'
        ));

        return redirect()
            ->route('staff.payments.history', $payment->staff_id)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Delete a payment record.
     */
    public function destroy(StaffPayment $payment)
    {
        $staffId = $payment->staff_id;
        $payment->delete();

        return redirect()
            ->route('staff.payments.history', $staffId)
            ->with('success', 'Payment deleted.');
    }

    /**
     * Summary — totals per department / per month + trend.
     */
    public function summary(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        [$year, $mon] = explode('-', $month);

        // Per-department totals for selected month
        $byDepartment = StaffPayment::paid()
            ->forMonth($year, $mon)
            ->join('staff', 'staff_payments.staff_id', '=', 'staff.id')
            ->join('departments', 'staff.department_id', '=', 'departments.id')
            ->select('departments.name as department', DB::raw('SUM(staff_payments.amount) as total'))
            ->groupBy('departments.id', 'departments.name')
            ->orderByDesc('total')
            ->get();

        // Last 6 months grand totals
        $last6Months = StaffPayment::paid()
            ->where('payment_date', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Top 5 earners this month
        $topEarners = StaffPayment::paid()
            ->forMonth($year, $mon)
            ->with('staff.department')
            ->select('staff_id', DB::raw('SUM(amount) as total'))
            ->groupBy('staff_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $grandTotal = StaffPayment::paid()->forMonth($year, $mon)->sum('amount');

        return view('admin.staff.payments.summary', compact(
            'byDepartment', 'last6Months', 'topEarners', 'grandTotal', 'month'
        ));
    }
}