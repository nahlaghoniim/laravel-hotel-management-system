<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:customers,email',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Collect form data
        $data = $request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'address'
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {

            $photoPath = $request->file('photo')
                                 ->store('customers', 'public');

            $data['photo'] = $photoPath;
        }

        // Save customer
        Customer::create($data);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:customers,email,' . $id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $customer = Customer::findOrFail($id);

        // Collect updated data
        $data = $request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'address'
        ]);

        // Upload new photo
        if ($request->hasFile('photo')) {

            $photoPath = $request->file('photo')
                                 ->store('customers', 'public');

            $data['photo'] = $photoPath;
        }

        // Update customer
        $customer->update($data);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}