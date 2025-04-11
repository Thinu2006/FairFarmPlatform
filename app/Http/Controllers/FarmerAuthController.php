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
        \Log::info('Farmer login page accessed.');
        return view('farmer.login');
    }

    public function showRegisterForm()
    {
        \Log::info('Farmer registration form accessed.');
        return view('auth.farmer_register');
    }

    public function register(Request $request)
    {
        \Log::info('Farmer registration attempt.', $request->only('FullName', 'Email', 'NIC'));

        $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => 'required|string|unique:farmers,NIC',
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:farmers,Email',
            'password' => 'required|string|min:6',
        ]);

        $farmer = Farmer::create($request->all());

        \Log::info('Farmer registered successfully.', ['FarmerID' => $farmer->FarmerID, 'Email' => $farmer->Email]);

        return redirect()->route('farmer.login')->with('success', 'Farmer registered successfully!');
    }

    public function login(Request $request)
    {
        \Log::info('Farmer login attempt.', ['Email' => $request->Email]);

        $request->validate([
            'Email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('Email', 'password');
        $farmer = Farmer::where('Email', $credentials['Email'])->first();

        if ($farmer && Hash::check($credentials['password'], $farmer->password)) {
            Auth::guard('farmer')->login($farmer);
            \Log::info('Farmer logged in successfully.', ['FarmerID' => $farmer->FarmerID, 'Email' => $farmer->Email]);
            return view('farmer.dashboard', ['name' => $farmer->FullName]);
        }

        \Log::warning('Farmer login failed.', ['Email' => $request->Email]);
        return back()->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        $farmer = Auth::guard('farmer')->user();
        \Log::info('Farmer logged out.', ['FarmerID' => $farmer?->FarmerID, 'Email' => $farmer?->Email]);
        Auth::guard('farmer')->logout();
        return redirect()->route('farmer.login');
    }

    public function showForgotPasswordForm()
    {
        \Log::info('Farmer forgot password page accessed.');
        return view('farmer.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['Email' => 'required|email']);
        $email = strtolower($request->Email);
        $farmer = Farmer::where('Email', $email)->first();

        if (!$farmer) {
            \Log::warning('Password reset attempt for non-existent email.', ['Email' => $email]);
            return back()->withErrors(['Email' => 'We can\'t find a user with that email address.']);
        }

        $token = Str::random(60);
        \DB::table('password_resets')->insert([
            'Email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetLink = url('/farmer/reset-password/' . $token . '?Email=' . urlencode($email));
        Mail::to($email)->send(new \App\Mail\PasswordResetLink($resetLink));

        \Log::info('Password reset link sent.', ['Email' => $email]);

        return back()->with('status', 'Password reset link sent to your email.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        \Log::info('Farmer reset password form accessed.', ['Email' => $request->Email]);
        return view('farmer.reset-password', [
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
        $resetRecord = \DB::table('password_resets')->where('Email', $email)->first();

        if (!$resetRecord) {
            \Log::warning('No reset record found.', ['Email' => $email]);
            return back()->withErrors(['Email' => 'No password reset request found for this email address.']);
        }

        if (!Hash::check($request->token, $resetRecord->token)) {
            \Log::warning('Invalid password reset token.', ['Email' => $email]);
            return back()->withErrors(['Email' => 'Invalid token or email address.']);
        }

        $tokenCreatedAt = \Carbon\Carbon::parse($resetRecord->created_at);
        if ($tokenCreatedAt->diffInMinutes(now()) > 60) {
            \Log::warning('Expired reset token.', ['Email' => $email]);
            return back()->withErrors(['Email' => 'The password reset link has expired.']);
        }

        $farmer = Farmer::where('Email', $email)->first();
        
        \Log::info('Farmer before password update.', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email,
        ]);

        $farmer->password = $request->password;
        $farmer->save();

        \Log::info('Farmer password updated successfully.', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email,
        ]);

        \DB::table('password_resets')->where('Email', $email)->delete();

        return redirect()->route('farmer.login')->with('status', 'Password reset successfully!');
    }
}
