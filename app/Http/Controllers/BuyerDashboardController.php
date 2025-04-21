<?php

namespace App\Http\Controllers;

use App\Models\FarmerSellingPaddyType;
use Illuminate\Http\Request;

class BuyerDashboardController extends Controller
{
    /**
     * Display the buyer dashboard.
     */
    public function index()
    {
        // Fetch the first 3 paddy types with related farmer and paddy type details
        $sellingPaddyTypes = FarmerSellingPaddyType::with(['farmer', 'paddyType'])
            ->where('Quantity', '>', 0) // Only show listings with quantity greater than 0
            ->limit(3) // Limit to 3 items
            ->get();

        // Pass the data to the buyer dashboard view
        return view('buyer.dashboard', compact('sellingPaddyTypes'));
    }
}
