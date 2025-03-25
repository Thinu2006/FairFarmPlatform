<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
            return redirect()->route('buyer.dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        Auth::guard('buyer')->logout();
        return redirect()->route('buyer.login');
    }
}
