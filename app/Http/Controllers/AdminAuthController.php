<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;

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
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP in session
            session(['admin_otp' => $otp, 'admin_email' => $admin->Email]);

            // Send OTP to email
            Mail::to($admin->Email)->send(new SendOTP($otp));

            // Redirect to OTP verification page
            return redirect()->route('admin.otp.verify');
        }

        // If login fails, return an error message
        return back()->with('error', 'Invalid email or password');
    }

    // Show OTP verification form
    public function showOTPVerificationForm()
    {
        return view('admin.otp-verify');
    }

    // Handle OTP verification
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if ($request->otp == session('admin_otp')) {
            // Find the admin by email
            $admin = Admin::where('Email', session('admin_email'))->first();

            // Authenticate the admin
            Auth::guard('admin')->login($admin);

            // Clear OTP session
            session()->forget(['admin_otp', 'admin_email']);

            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }

        // If OTP verification fails, return an error message
        return back()->with('error', 'Invalid OTP');
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