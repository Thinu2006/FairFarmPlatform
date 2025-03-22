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
            'Username' => 'required|string',
            'Password' => 'required|string|min:8',
        ]);

        // Get credentials
        $credentials = $request->only('Username', 'Password');

        // Find the admin by username
        $admin = Admin::where('Username', $credentials['Username'])->first();

        // Check if admin exists and if the password is correct
        if ($admin && Hash::check($credentials['Password'], $admin->Password)) {
            // Attempt to authenticate the admin
            Auth::guard('admin')->login($admin, $request->remember);

            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }

        // If login fails, return an error message
        return back()->with('error', 'Invalid username or password');
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
