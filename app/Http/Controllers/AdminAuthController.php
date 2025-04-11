<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendOTP;

class AdminAuthController extends Controller
{
    // Show the admin login form
    public function showLoginForm()
    {
        Log::info('Admin login form displayed.');
        return view('admin.login');  
    }

    // Handle the login request
    public function login(Request $request)
    {
        $request->validate([
            'Email' => 'required|string|email',
            'Password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('Email', 'Password');
        $remember = $request->has('remember'); 

        Log::info('Admin login attempt', ['email' => $credentials['Email']]);

        $admin = Admin::where('Email', $credentials['Email'])->first();

        if ($admin && Hash::check($credentials['Password'], $admin->Password)) {
            $otp = rand(100000, 999999);
            Log::info('Login successful. OTP generated and email sent.', ['email' => $admin->Email, 'otp' => $otp]);

            session([
                'admin_otp' => $otp, 
                'admin_email' => $admin->Email,
                'remember_me' => $remember 
            ]);

            Mail::to($admin->Email)->send(new SendOTP($otp));
            return redirect()->route('admin.otp.verify');
        }

        Log::warning('Login failed. Invalid credentials.', ['email' => $credentials['Email']]);
        return back()->with('error', 'Invalid email or password');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        Log::info('OTP verification attempt', ['otp_entered' => $request->otp]);

        if ($request->otp == session('admin_otp')) {
            $admin = Admin::where('Email', session('admin_email'))->first();

            Auth::guard('admin')->login($admin, session('remember_me', false));
            Log::info('OTP verified successfully. Admin logged in.', ['email' => $admin->Email]);

            session()->forget(['admin_otp', 'admin_email', 'remember_me']);
            return redirect()->route('admin.dashboard');
        }

        Log::warning('OTP verification failed.', ['otp_entered' => $request->otp]);
        return back()->with('error', 'Invalid OTP');
    }

    // Show OTP verification form
    public function showOTPVerificationForm()
    {
        Log::info('OTP verification form displayed.');
        return view('admin.otp-verify');
    }

    // Handle the logout request
    public function logout()
    {
        $email = Auth::guard('admin')->user()->Email ?? 'Unknown';
        Auth::guard('admin')->logout();
        Log::info('Admin logged out.', ['email' => $email]);
        return redirect()->route('admin.login');
    }
}
