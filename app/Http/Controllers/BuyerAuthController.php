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
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

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

        \Log::info('Registering new buyer:', $request->only(['FullName', 'Email', 'NIC']));

        Buyer::create($request->all());

        \Log::info('Buyer registered successfully', ['Email' => $request->Email]);

        return redirect()->route('buyer.login')->with('success', 'Buyer registered successfully!');
    }

    public function buyerLogin(Request $request)
    {
        $request->validate([
            'Email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('Email', 'password');

        \Log::info('Login attempt:', [
            'Email' => $credentials['Email'],
            'Password' => $credentials['password'],
        ]);

        if (Auth::guard('buyer')->attempt($credentials)) {
            $buyer = Auth::guard('buyer')->user();

            $otp = Str::random(6);
            Session::put('otp', $otp);
            Session::put('buyer_id', $buyer->BuyerID);

            Mail::to($buyer->Email)->send(new SendOTP($otp));

            \Log::info("OTP for buyer {$buyer->Email}: {$otp}");

            return redirect()->route('buyer.otp.verify');
        }

        \Log::warning("Login failed for email: {$credentials['Email']}");
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
            \Log::info("OTP verified successfully for buyer_id: {$buyer_id}");

            $buyer = Buyer::find($buyer_id);
            Auth::guard('buyer')->login($buyer);

            Session::forget(['otp', 'buyer_id']);

            return redirect()->route('buyer.dashboard');
        }

        \Log::warning("OTP verification failed for buyer_id: {$buyer_id}, entered OTP: {$request->otp}");
        return back()->with('error', 'Invalid OTP');
    }

    public function logout()
    {
        $buyer = Auth::guard('buyer')->user();
        \Log::info("Buyer logged out", [
            'BuyerID' => $buyer?->BuyerID,
            'Email' => $buyer?->Email
        ]);

        Auth::guard('buyer')->logout();
        return redirect()->route('buyer.login');
    }

    public function showForgotPasswordForm()
    {
        return view('buyer.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['Email' => 'required|email']);

        $email = strtolower($request->Email);
        $buyer = Buyer::where('Email', '=', $email)->first();

        if (!$buyer) {
            \Log::warning("Password reset failed: email not found", ['Email' => $email]);
            return back()->withErrors(['Email' => 'We can\'t find a user with that email address.']);
        }

        $token = Str::random(60);
        \DB::table('password_resets')->insert([
            'Email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetLink = url('/buyer/reset-password/' . $token . '?Email=' . urlencode($email));
        Mail::to($email)->send(new \App\Mail\PasswordResetLink($resetLink));

        \Log::info("Password reset link generated", ['Email' => $email, 'Token' => $token]);

        return back()->with('status', 'Password reset link sent to your email.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('buyer.reset-password', [
            'token' => $token,
            'Email' => $request->Email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'Email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = urldecode($request->Email);
        $resetRecord = \DB::table('password_resets')
            ->where('Email', $email)
            ->first();

        if (!$resetRecord) {
            \Log::warning("Password reset attempt failed: no record found", ['Email' => $email]);
            return back()->withErrors(['Email' => 'No password reset request found for this email address.']);
        }

        if (!Hash::check($request->token, $resetRecord->token)) {
            \Log::warning("Password reset failed: token mismatch", ['Email' => $email]);
            return back()->withErrors(['Email' => 'Invalid token or email address.']);
        }

        $tokenCreatedAt = \Carbon\Carbon::parse($resetRecord->created_at);
        $tokenExpired = $tokenCreatedAt->diffInMinutes(now()) > 60;

        if ($tokenExpired) {
            \Log::warning("Password reset failed: token expired", ['Email' => $email]);
            return back()->withErrors(['Email' => 'The password reset link has expired.']);
        }

        $buyer = Buyer::where('Email', $email)->first();

        \Log::info('Buyer before password update:', [
            'BuyerID' => $buyer->BuyerID,
            'Email' => $buyer->Email,
            'Current Password Hash' => $buyer->password,
        ]);

        $buyer->password = $request->password;
        $buyer->save();

        \Log::info('Buyer after password update:', [
            'BuyerID' => $buyer->BuyerID,
            'Email' => $buyer->Email,
            'New Password Hash' => $buyer->password,
        ]);

        \DB::table('password_resets')->where('Email', $email)->delete();

        return redirect()->route('buyer.login')->with('status', 'Password reset successfully!');
    }
}
