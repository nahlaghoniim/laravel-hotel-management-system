<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Show login form
    public function login()
    {
        // If already logged in, skip the login page
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    // Handle login
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $remember = $request->boolean('remember'); // true if checkbox is checked

        if (Auth::guard('admin')->attempt($credentials, $remember)) {

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withInput($request->only('email', 'remember')) // preserve email & checkbox
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}