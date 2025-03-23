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
    // Your existing methods (e.g., showBuyerLogin, buyerLogin, etc.)

    // Keep the password reset functionality from HEAD
    public function showForgotPasswordForm()
    {
        return view('buyer.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Your existing code for sending reset link
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
        // Your existing code for resetting password
    }
}