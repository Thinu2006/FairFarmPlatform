<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}