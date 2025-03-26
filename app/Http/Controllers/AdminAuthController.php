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
        $request->validate([
            'Email' => 'required|string|email',
            'Password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('Email', 'Password');
        $remember = $request->has('remember'); // This captures the checkbox state

        $admin = Admin::where('Email', $credentials['Email'])->first();

        if ($admin && Hash::check($credentials['Password'], $admin->Password)) {
            $otp = rand(100000, 999999);

            session([
                'admin_otp' => $otp, 
                'admin_email' => $admin->Email,
                'remember_me' => $remember // Store the remember choice
            ]);

            Mail::to($admin->Email)->send(new SendOTP($otp));
            return redirect()->route('admin.otp.verify');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if ($request->otp == session('admin_otp')) {
            $admin = Admin::where('Email', session('admin_email'))->first();
            
            // Use the remember_me value from session
            Auth::guard('admin')->login($admin, session('remember_me', false));

            session()->forget(['admin_otp', 'admin_email', 'remember_me']);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid OTP');
    }

    // Show OTP verification form
    public function showOTPVerificationForm()
    {
        return view('admin.otp-verify');
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