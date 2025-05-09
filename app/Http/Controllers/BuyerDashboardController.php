<?php

namespace App\Http\Controllers;

use App\Models\FarmerSellingPaddyType;
use Illuminate\Http\Request;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        // Get top 3 best selling paddy types
        $topSellingPaddies = FarmerSellingPaddyType::with(['farmer', 'paddyType'])
            ->where('Quantity', '>', 0)
            ->withCount(['orders as total_orders'])
            ->withSum('orders as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();
    
        return view('buyer.dashboard', compact('topSellingPaddies'));
    }

    public function account()
    {
        $buyer = auth('buyer')->user();
        return view('buyer.account', compact('buyer'));
    }

    public function updateAccount(Request $request)
    {
        $buyer = auth('buyer')->user();
        
        $validated = $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => 'required|string|max:12',
            'ContactNo' => 'required|string|max:15',
            'Address' => 'required|string|max:255',
            'Email' => 'required|email|unique:buyers,Email,'.$buyer->BuyerID.',BuyerID',
        ]);
        
        $buyer->update($validated);
        
        return back()->with('success', 'Account updated successfully!');
    }
}
