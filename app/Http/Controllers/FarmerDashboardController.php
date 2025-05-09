<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerDashboardController extends Controller
{
    public function account()
    {
        $farmer = auth('farmer')->user();
        return view('farmer.account', compact('farmer'));
    }

    public function updateAccount(Request $request)
    {
        $farmer = auth('farmer')->user();
        
        $validated = $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => 'required|string|max:12|unique:farmers,NIC,'.$farmer->FarmerID.',FarmerID',
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|email|unique:farmers,Email,'.$farmer->FarmerID.',FarmerID',
        ]);
        
        $farmer->update($validated);
        
        return back()->with('success', 'Account updated successfully!');
    }
}