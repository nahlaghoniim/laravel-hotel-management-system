<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->get();
        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'detail' => 'nullable|string',
        ]);

        Department::create($request->only('title', 'detail'));

        return redirect()->route('departments.index')
                         ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        return view('admin.department.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'detail' => 'nullable|string',
        ]);

        $department->update($request->only('title', 'detail'));

        return redirect()->route('departments.index')
                         ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
                         ->with('success', 'Department deleted.');
    }
}