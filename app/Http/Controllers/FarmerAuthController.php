<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Mail\PasswordResetLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FarmerAuthController extends Controller
{
    /**
     * Show farmer login form
     */
    public function showFarmerLogin()
    {
        Log::info('Farmer login page accessed');
        return view('farmer.login');
    }

    /**
     * Show farmer registration form
     */
    public function showRegisterForm()
    {
        Log::info('Farmer registration form accessed');
        return view('auth.farmer_register');
    }

    /**
     * Register a new farmer
     */
    public function register(Request $request)
    {
        Log::info('Farmer registration attempt', $request->only('FullName', 'Email', 'NIC'));
        
        $validated = $this->validateRegistrationRequest($request);
        $farmer = $this->createFarmer($validated);

        Log::info('Farmer registered successfully', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email
        ]);

        return redirect()->route('farmer.login')
            ->with('success', 'Farmer registered successfully!');
    }

    /**
     * Authenticate farmer
     */
    public function login(Request $request)
    {
        Log::info('Farmer login attempt', ['Email' => $request->Email]);
        
        $validated = $this->validateLoginRequest($request);
        
        if ($this->attemptLogin($validated)) {
            return $this->handleSuccessfulLogin();
        }

        Log::warning('Farmer login failed', ['Email' => $request->Email]);
        return back()->with('error', 'Invalid username or password');
    }

    /**
     * Logout farmer
     */
    public function logout()
    {
        $this->logLogout();
        Auth::guard('farmer')->logout();
        return redirect()->route('farmer.login');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        Log::info('Farmer forgot password page accessed');
        return view('farmer.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(Request $request)
    {
        $email = $this->validateAndNormalizeEmail($request);
        
        if (!$this->farmerExists($email)) {
            Log::warning('Password reset attempt for non-existent email', ['Email' => $email]);
            return back()->withErrors(['Email' => 'We can\'t find a user with that email address.']);
        }

        $this->createAndSendResetToken($email);
        return back()->with('status', 'Password reset link sent to your email.');
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        Log::info('Farmer reset password form accessed', ['Email' => $request->Email]);
        return view('farmer.reset-password', [
            'token' => $token,
            'Email' => $request->Email,
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $validated = $this->validatePasswordResetRequest($request);
        $email = urldecode($validated['Email']);

        if (!$this->isValidResetToken($email, $validated['token'])) {
            return back()->withErrors(['Email' => 'Invalid or expired password reset token.']);
        }

        $this->updateFarmerPassword($email, $validated['password']);
        return redirect()->route('farmer.login')->with('status', 'Password reset successfully!');
    }

    /**
     * Check if NIC is unique
     */
    public function checkNicUnique(Request $request)
    {
        $validated = $request->validate(['nic' => 'required|string']);
        $exists = Farmer::where('NIC', $validated['nic'])->exists();
        return response()->json(['exists' => $exists]);
    }

    // ==================== Protected Helper Methods ====================

    protected function validateRegistrationRequest(Request $request)
    {
        return $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => 'required|string|unique:farmers,NIC',
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:farmers,Email',
            'password' => 'required|string|min:6',
        ]);
    }

    protected function createFarmer(array $validatedData)
    {
        return Farmer::create([
            'FullName' => $validatedData['FullName'],
            'NIC' => $validatedData['NIC'],
            'ContactNo' => $validatedData['ContactNo'],
            'Address' => $validatedData['Address'],
            'Email' => $validatedData['Email'],
            'password' => Hash::make($validatedData['password']),
        ]);
    }

    protected function validateLoginRequest(Request $request)
    {
        return $request->validate([
            'Email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
    }

    protected function attemptLogin(array $credentials)
    {
        $farmer = Farmer::where('Email', $credentials['Email'])->first();
        return $farmer && Hash::check($credentials['password'], $farmer->password);
    }

    protected function handleSuccessfulLogin()
    {
        $farmer = Farmer::where('Email', request('Email'))->first();
        Auth::guard('farmer')->login($farmer);
        
        Log::info('Farmer logged in successfully', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email
        ]);
        
        return redirect()->route('farmer.dashboard');
    }

    protected function validateAndNormalizeEmail(Request $request)
    {
        $request->validate(['Email' => 'required|email']);
        return strtolower($request->Email);
    }

    protected function farmerExists(string $email)
    {
        return Farmer::where('Email', $email)->exists();
    }

    protected function createAndSendResetToken(string $email)
    {
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'Email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetLink = url('/farmer/reset-password/' . $token . '?Email=' . urlencode($email));
        Mail::to($email)->send(new PasswordResetLink($resetLink));

        Log::info('Password reset link sent', ['Email' => $email]);
    }

    protected function validatePasswordResetRequest(Request $request)
    {
        return $request->validate([
            'token' => 'required',
            'Email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    protected function isValidResetToken(string $email, string $token)
    {
        $resetRecord = DB::table('password_resets')->where('Email', $email)->first();

        if (!$resetRecord) {
            Log::warning('No reset record found', ['Email' => $email]);
            return false;
        }

        if (!Hash::check($token, $resetRecord->token)) {
            Log::warning('Invalid password reset token', ['Email' => $email]);
            return false;
        }

        if (Carbon::parse($resetRecord->created_at)->diffInMinutes(now()) > 60) {
            Log::warning('Expired reset token', ['Email' => $email]);
            return false;
        }

        return true;
    }

    protected function updateFarmerPassword(string $email, string $newPassword)
    {
        $farmer = Farmer::where('Email', $email)->first();
        
        Log::info('Farmer before password update', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email,
        ]);

        $farmer->password = Hash::make($newPassword);
        $farmer->save();

        Log::info('Farmer password updated successfully', [
            'FarmerID' => $farmer->FarmerID,
            'Email' => $farmer->Email,
        ]);

        DB::table('password_resets')->where('Email', $email)->delete();
    }

    protected function logLogout()
    {
        $farmer = Auth::guard('farmer')->user();
        Log::info('Farmer logged out', [
            'FarmerID' => $farmer?->FarmerID,
            'Email' => $farmer?->Email
        ]);
    }
}