<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;

class BuyerAuthController extends Controller
{
    public function showBuyerLogin()
    {
        return view('buyer.login');
    }

    public function showBuyerRegisterForm()
    {
        return view('auth.buyer_register');
    }

    public function buyerRegister(Request $request)
    {
        $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => 'required|string|unique:buyers,NIC',
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:buyers,Email',
            'password' => 'required|string|min:6',
        ]);

        Buyer::create($request->all());

        return redirect()->route('buyer.login')->with('success', 'Buyer registered successfully!');
    }

    public function buyerLogin(Request $request)
    {
        $request->validate([
            'Email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('Email', 'password');

        if (Auth::guard('buyer')->attempt($credentials)) {
            $buyer = Auth::guard('buyer')->user();

            // Generate OTP
            $otp = Str::random(6);
            Session::put('otp', $otp);
            Session::put('buyer_id', $buyer->BuyerID);

            // Send OTP to buyer via email
            Mail::to($buyer->Email)->send(new SendOTP($otp));

            // Log the OTP for debugging
            \Log::info("OTP for buyer {$buyer->Email}: {$otp}");

            // Redirect to OTP verification page
            return redirect()->route('buyer.otp.verify');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function showOTPVerificationForm()
    {
        return view('buyer.OTPVerification');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $otp = Session::get('otp');
        $buyer_id = Session::get('buyer_id');

        if ($request->otp === $otp) {
            $buyer = Buyer::find($buyer_id);
            Auth::guard('buyer')->login($buyer);

            // Clear the OTP and buyer_id from session
            Session::forget(['otp', 'buyer_id']);

            return redirect()->route('buyer.dashboard');
        }

        return back()->with('error', 'Invalid OTP');
    }

    public function logout()
    {
        Auth::guard('buyer')->logout();
        return redirect()->route('buyer.login');
    }
}