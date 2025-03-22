<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'NIC' => 'required|string|unique:buyers,NIC',  // Correct table name
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:buyers,Email',  // Correct table name
            'password' => 'required|string|min:6',
        ]);

        // Create a new buyer (use the Buyer model)
        Buyer::create($request->all());

        return redirect()->route('buyer.login')->with('success', 'Buyer registered successfully!');
    }

    public function buyerLogin(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'Email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        // Get credentials
        $credentials = $request->only('Email', 'password');

        // Find the buyer by email
        $buyer = Buyer::where('Email', $credentials['Email'])->first();

        // Check if buyer exists and if the password is correct
        if ($buyer && Hash::check($credentials['password'], $buyer->password)) {
            // Attempt to authenticate the buyer using the buyer guard
            Auth::guard('buyer')->login($buyer);

            // Redirect to the farmer dashboard
            return view('buyer.dashboard', ['name' => $buyer->FullName]);
        }

        // If login fails, return an error message
        return back()->with('error', 'Invalid email or password');
    }


    // Handle the logout request
    public function logout()
    {
        // Log out the buyer
        Auth::guard('buyer')->logout();

        // Redirect to the buyer login page
        return redirect()->route('buyer.login');
    }
}
