<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function profile(Request $request)
    {
        $admin = $request->user('admin');

        return view('admin.account.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = $request->user('admin');

        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
        ]);

        $admin->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function settings(Request $request)
    {
        $admin = $request->user('admin');

        return view('admin.account.settings', compact('admin'));
    }

    public function updatePassword(Request $request)
    {
        $admin = $request->user('admin');

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($data['current_password'], $admin->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $admin->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
