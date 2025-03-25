<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // Show the admin login form
    public function showLoginForm()
    {
        return view('admin.login');  // Ensure this view exists in resources/views/admin/login.blade.php
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'Email' => 'required|string|email',
            'Password' => 'required|string|min:8',
        ]);

        // Get credentials
        $credentials = $request->only('Email', 'Password');

        // Find the admin by email
        $admin = Admin::where('Email', $credentials['Email'])->first();

        // Check if admin exists and if the password is correct
        if ($admin && Hash::check($credentials['Password'], $admin->Password)) {
            // Authenticate the admin
            Auth::guard('admin')->login($admin);

            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }

        // If login fails, return an error message
        return back()->with('error', 'Invalid email or password');
    }

    // Handle the logout request
    public function logout()
    {
        // Log out the admin
        Auth::guard('admin')->logout();

        // Redirect to the admin login page
        return redirect()->route('admin.login');
    }
}
