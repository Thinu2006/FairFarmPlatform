<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Farmer;
use App\Models\Order;
use App\Models\PaddyType;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Calculate shipping revenue from completed orders (5% of order total)
        $completedOrders = Order::whereIn('status', ['delivered', 'completed'])->get();
        $completedShippingRevenue = $completedOrders->sum('total_amount') * 0.05;

        // Get top 3 buyers by number of orders
        $topBuyers = Buyer::withCount('orders')
            ->orderByDesc('orders_count')
            ->limit(3)
            ->get();

        // Get top 3 farmers by number of orders
        $topFarmers = Farmer::withCount('orders')
            ->orderByDesc('orders_count')
            ->limit(3)
            ->get();

        $stats = [
            'total_farmers' => Farmer::count(),
            'total_buyers' => Buyer::count(),
            'total_orders' => Order::count(),
            'shipping_revenue' => $completedShippingRevenue,
            
            // Order status counts
            'pending_orders_count' => Order::where('status', 'pending')->count(),
            'processing_orders_count' => Order::where('status', 'processing')->count(),
            'delivery_started_orders_count' => Order::where('status', 'delivery_started')->count(),
            'completed_orders_count' => Order::whereIn('status', ['delivered', 'completed'])->count(),
            'cancelled_orders_count' => Order::where('status', 'cancelled')->count(),
            
            // Top performers
            'top_buyers' => $topBuyers,
            'top_farmers' => $topFarmers,
            
            'recent_orders' => Order::with(['buyer', 'farmer'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}