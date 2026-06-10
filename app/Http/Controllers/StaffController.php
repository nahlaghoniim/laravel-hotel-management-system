<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
   public function index()
{
    $staff = Staff::with(['department', 'payments'])->latest()->get();

    $totalPaidThisMonth = \App\Models\StaffPayment::paid()
        ->forMonth(now()->year, now()->month)
        ->sum('amount');

    return view('admin.staff.index', compact('staff', 'totalPaidThisMonth'));
}

    public function create()
    {
        $departments = Department::all();
        return view('admin.staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'full_name'     => 'required|string|max:255',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'           => 'nullable|string',
            'salary_type'   => 'required|in:daily,monthly',
            'salary_amount' => 'required|numeric|min:0',
        ]);

        $data = $request->only('department_id', 'full_name', 'bio', 'salary_type', 'salary_amount');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }

        Staff::create($data);

        return redirect()->route('staff.index')
                         ->with('success', 'Staff member added successfully.');
    }

    public function show(Staff $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $departments = Department::all();
        return view('admin.staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'full_name'     => 'required|string|max:255',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'           => 'nullable|string',
            'salary_type'   => 'required|in:daily,monthly',
            'salary_amount' => 'required|numeric|min:0',
        ]);

        $data = $request->only('department_id', 'full_name', 'bio', 'salary_type', 'salary_amount');

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($staff->photo) {
                Storage::disk('public')->delete($staff->photo);
            }
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }

        $staff->update($data);

        return redirect()->route('staff.index')
                         ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }

        $staff->delete();

        return redirect()->route('staff.index')
                         ->with('success', 'Staff member deleted.');
    }
}