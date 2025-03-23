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

        \Log::info('Login attempt:', [
            'Email' => $credentials['Email'],
            'Password' => $credentials['password'], // Log the plaintext password (for debugging only)
        ]);

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


    


    // Show Forgot Password Form
    public function showForgotPasswordForm()
    {
        return view('buyer.forgot-password');
    }

    // Send Password Reset Link
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the request
        $request->validate(['Email' => 'required|email']);

        // Convert email to lowercase for consistency
        $email = strtolower($request->Email);

        // Check if the email exists in the buyers table
        $buyer = Buyer::where('Email', '=', $email)->first();

        if (!$buyer) {
            return back()->withErrors(['Email' => 'We can\'t find a user with that email address.']);
        }

        // Manually create the password reset token and save it to the password_resets table
        $token = Str::random(60);
        \DB::table('password_resets')->insert([
            'Email' => $email, // Use 'Email' instead of 'email'
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Send the password reset link email
        $resetLink = url('/buyer/reset-password/' . $token . '?Email=' . urlencode($email));
        Mail::to($email)->send(new \App\Mail\PasswordResetLink($resetLink));

        return back()->with('status', 'Password reset link sent to your email.');
    }

    // Show Reset Password Form
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('buyer.reset-password', [
            'token' => $token,
            'Email' => $request->Email,
        ]);
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'Email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Decode the email address from the URL
        $email = urldecode($request->Email);

        // Find the password reset record
        $resetRecord = \DB::table('password_resets')
            ->where('Email', $email)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['Email' => 'No password reset request found for this email address.']);
        }

        // Debugging: Log token and email details
        \Log::info('Reset password request:', [
            'Email' => $email,
            'Token from URL' => $request->token,
            'Hashed Token from URL' => Hash::make($request->token), // Hash the token from the URL
            'Hashed Token from DB' => $resetRecord->token,
            'Token matches' => Hash::check($request->token, $resetRecord->token),
        ]);

        // Check if the token matches
        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['Email' => 'Invalid token or email address.']);
        }

        // Check if the token has expired (e.g., tokens expire after 60 minutes)
        $tokenCreatedAt = \Carbon\Carbon::parse($resetRecord->created_at);
        $tokenExpired = $tokenCreatedAt->diffInMinutes(now()) > 60;

        \Log::info('Token expiry check:', [
            'Token Created At' => $resetRecord->created_at,
            'Current Time' => now(),
            'Token Expired' => $tokenExpired,
        ]);

        if ($tokenExpired) {
            return back()->withErrors(['Email' => 'The password reset link has expired.']);
        }

        // Update the buyer's password
        $buyer = Buyer::where('Email', $email)->first();

        \Log::info('Buyer before password update:', [
            'BuyerID' => $buyer->BuyerID,
            'Email' => $buyer->Email,
            'Current Password Hash' => $buyer->password,
        ]);

        $buyer->password = Hash::make($request->password);
        $buyer->save();

        \Log::info('Buyer after password update:', [
            'BuyerID' => $buyer->BuyerID,
            'Email' => $buyer->Email,
            'New Password Hash' => $buyer->password,
        ]);

        // Delete the password reset record
        \DB::table('password_resets')->where('Email', $email)->delete();

        return redirect()->route('buyer.login')->with('status', 'Password reset successfully!');
    }
}