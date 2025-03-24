<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FarmerAuthController extends Controller
{

    public function showFarmerLogin()
    {
        return view('farmer.login');
    }

    public function showRegisterForm()
    {
        return view('auth.farmer_register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => 'required|string|unique:farmers,NIC',
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:farmers,Email',
            'password' => 'required|string|min:6',
        ]);

        Farmer::create($request->all());

        return redirect()->route('farmer.login')->with('success', 'Farmer registered successfully!');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'Email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        // Get credentials
        $credentials = $request->only('Email', 'password');

        // Find the farmer by username
        $farmer = Farmer::where('Email', $credentials['Email'])->first();

        // Check if farmer exists and if the password is correct
        if ($farmer && Hash::check($credentials['password'], $farmer->password)) {
            // Attempt to authenticate the farmer
            Auth::guard('farmer')->login($farmer);

            // Redirect to the farmer dashboard
            return view('farmer.dashboard', ['name' => $farmer->FullName]);
        }

        // If login fails, return an error message
        return back()->with('error', 'Invalid username or password');
    }
    // Handle the logout request
    public function logout()
    {
        // Log out the farmer
        Auth::guard('farmer')->logout();

        // Redirect to the farmer login page
        return redirect()->route('farmer.login');
    }




    // Show Forgot Password Form
    public function showForgotPasswordForm()
    {
        return view('farmer.forgot-password');
    }

    // Send Password Reset Link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['Email' => 'required|email']);
        $email = strtolower($request->Email);
        $farmer = Farmer::where('Email', $email)->first();

        if (!$farmer) {
            return back()->withErrors(['Email' => 'We can\'t find a user with that email address.']);
        }

        $token = Str::random(60); // Now properly referenced
        \DB::table('password_resets')->insert([
            'Email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetLink = url('/farmer/reset-password/' . $token . '?Email=' . urlencode($email));
        Mail::to($email)->send(new \App\Mail\PasswordResetLink($resetLink));

        return back()->with('status', 'Password reset link sent to your email.');
    }

    // Show Reset Password Form
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('farmer.reset-password', [
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

        // Check if the token matches
        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['Email' => 'Invalid token or email address.']);
        }

        // Check if the token has expired (e.g., tokens expire after 60 minutes)
        $tokenCreatedAt = \Carbon\Carbon::parse($resetRecord->created_at);
        $tokenExpired = $tokenCreatedAt->diffInMinutes(now()) > 60;

        if ($tokenExpired) {
            return back()->withErrors(['Email' => 'The password reset link has expired.']);
        }

        // Update the farmer's password - DON'T use Hash::make() since the mutator will handle it
        $farmer = Farmer::where('Email', $email)->first();
        
        \Log::info('Farmer before password update:', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email,
            'Current Password Hash' => $farmer->password,
        ]);

        // Set the plain text password - the mutator will hash it automatically
        $farmer->password = $request->password;
        $farmer->save();

        \Log::info('Farmer after password update:', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email,
            'New Password Hash' => $farmer->password,
        ]);

        // Delete the password reset record
        \DB::table('password_resets')->where('Email', $email)->delete();

        return redirect()->route('farmer.login')->with('status', 'Password reset successfully!');
    }
}