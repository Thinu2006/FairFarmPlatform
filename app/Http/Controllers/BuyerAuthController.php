<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Mail\SendOTP;
use App\Mail\PasswordResetLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BuyerAuthController extends Controller
{
    /**
     * Show buyer login form
     */
    public function showBuyerLogin()
    {
        return view('buyer.login');
    }

    /**
     * Show buyer registration form
     */
    public function showBuyerRegisterForm()
    {
        return view('auth.buyer_register');
    }

    /**
     * Check if NIC is unique
     */
    public function checkNicUnique(Request $request)
    {
        $validated = $request->validate(['nic' => 'required|string']);
        $exists = Buyer::where('NIC', $validated['nic'])->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Register a new buyer
     */
    public function buyerRegister(Request $request)
    {
        $validated = $this->validateRegistrationRequest($request);
        
        $buyer = Buyer::create([
            'FullName' => $validated['FullName'],
            'NIC' => $validated['NIC'],
            'ContactNo' => $validated['ContactNo'],
            'Address' => $validated['Address'],
            'Email' => $validated['Email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('buyer.login')
            ->with('success', 'Buyer registered successfully!');
    }

    /**
     * Handle buyer login
     */
    public function buyerLogin(Request $request)
    {
        $validated = $this->validateLoginRequest($request);
        $credentials = $this->getLoginCredentials($validated);

        $this->logLoginAttempt($credentials);

        if (!Auth::guard('buyer')->attempt($credentials)) {
            $this->logFailedLogin($credentials['Email']);
            return back()->with('error', 'Invalid email or password');
        }

        return $this->processSuccessfulLogin();
    }

    /**
     * Show OTP verification form
     */
    public function showOtpVerificationForm()
    {
        return view('buyer.OTPVerification');
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate(['otp' => 'required|string|size:6']);
        
        if (!$this->isValidOtp($validated['otp'])) {
            $this->logFailedOtpVerification();
            return back()->with('error', 'Invalid OTP');
        }

        return $this->processSuccessfulOtpVerification();
    }

    /**
     * Logout buyer
     */
    public function logout()
    {
        $this->logLogout();
        Auth::guard('buyer')->logout();
        return redirect()->route('buyer.login');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('buyer.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate(['Email' => 'required|email']);
        $email = strtolower($validated['Email']);

        if (!$this->buyerExists($email)) {
            $this->logPasswordResetFailure($email);
            return back()->withErrors(['Email' => 'We can\'t find a user with that email address.']);
        }

        $this->createPasswordResetToken($email);
        return back()->with('status', 'Password reset link sent to your email.');
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('buyer.reset-password', [
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

        if (!$this->isValidPasswordResetToken($email, $validated['token'])) {
            return back()->withErrors(['Email' => 'Invalid or expired password reset token.']);
        }

        $this->updateBuyerPassword($email, $validated['password']);
        return redirect()->route('buyer.login')->with('status', 'Password reset successfully!');
    }

    // ==================== Protected Helper Methods ====================

    protected function validateRegistrationRequest(Request $request)
    {
        return $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => 'required|string|unique:buyers,NIC',
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:buyers,Email',
            'password' => 'required|string|min:6',
        ]);
    }

    protected function validateLoginRequest(Request $request)
    {
        return $request->validate([
            'Email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
    }

    protected function getLoginCredentials(array $validated)
    {
        return [
            'Email' => $validated['Email'],
            'password' => $validated['password']
        ];
    }

    protected function processSuccessfulLogin()
    {
        $buyer = Auth::guard('buyer')->user();
        $otp = $this->generateAndStoreOtp($buyer);
        $this->sendOtpEmail($buyer, $otp);
        return redirect()->route('buyer.otp.verify');
    }

    protected function generateAndStoreOtp(Buyer $buyer)
    {
        $otp = Str::random(6);
        Session::put('otp', $otp);
        Session::put('buyer_id', $buyer->BuyerID);
        Log::info("OTP for buyer {$buyer->Email}: {$otp}");
        return $otp;
    }

    protected function sendOtpEmail(Buyer $buyer, string $otp)
    {
        Mail::to($buyer->Email)->send(new SendOTP($otp));
    }

    protected function isValidOtp(string $enteredOtp)
    {
        return $enteredOtp === Session::get('otp');
    }

    protected function processSuccessfulOtpVerification()
    {
        $buyer = Buyer::find(Session::get('buyer_id'));
        Auth::guard('buyer')->login($buyer);
        Session::forget(['otp', 'buyer_id']);
        return redirect()->route('buyer.dashboard');
    }

    protected function validatePasswordResetRequest(Request $request)
    {
        return $request->validate([
            'token' => 'required',
            'Email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    protected function buyerExists(string $email)
    {
        return Buyer::where('Email', $email)->exists();
    }

    protected function createPasswordResetToken(string $email)
    {
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'Email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetLink = url('/buyer/reset-password/' . $token . '?Email=' . urlencode($email));
        Mail::to($email)->send(new PasswordResetLink($resetLink));
        Log::info("Password reset link generated", ['Email' => $email, 'Token' => $token]);
    }

    protected function isValidPasswordResetToken(string $email, string $token)
    {
        $resetRecord = DB::table('password_resets')->where('Email', $email)->first();

        if (!$resetRecord) {
            Log::warning("Password reset attempt failed: no record found", ['Email' => $email]);
            return false;
        }

        if (!Hash::check($token, $resetRecord->token)) {
            Log::warning("Password reset failed: token mismatch", ['Email' => $email]);
            return false;
        }

        if (Carbon::parse($resetRecord->created_at)->diffInMinutes(now()) > 60) {
            Log::warning("Password reset failed: token expired", ['Email' => $email]);
            return false;
        }

        return true;
    }

    protected function updateBuyerPassword(string $email, string $newPassword)
    {
        $buyer = Buyer::where('Email', $email)->first();
        $buyer->password = Hash::make($newPassword);
        $buyer->save();
        DB::table('password_resets')->where('Email', $email)->delete();
    }

    protected function logLoginAttempt(array $credentials)
    {
        Log::info('Login attempt:', [
            'Email' => $credentials['Email'],
            'Password' => '******',
        ]);
    }

    protected function logFailedLogin(string $email)
    {
        Log::warning("Login failed for email: {$email}");
    }

    protected function logFailedOtpVerification()
    {
        Log::warning("OTP verification failed for buyer_id: " . Session::get('buyer_id'));
    }

    protected function logPasswordResetFailure(string $email)
    {
        Log::warning("Password reset failed: email not found", ['Email' => $email]);
    }

    protected function logLogout()
    {
        $buyer = Auth::guard('buyer')->user();
        Log::info("Buyer logged out", [
            'BuyerID' => $buyer?->BuyerID,
            'Email' => $buyer?->Email
        ]);
    }
}