<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Buyer;
use App\Models\Farmer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => $this->getDashboardStatistics()
        ]);
    }

    /**
     * Show admin account details
     */
    public function account()
    {
        return view('admin.account', [
            'admin' => Auth::guard('admin')->user()
        ]);
    }

    /**
     * Get all dashboard statistics
     */
    protected function getDashboardStatistics(): array
    {
        return array_merge(
            $this->getUserCounts(),
            $this->getOrderStatistics(),
            $this->getRevenueStatistics(),
            $this->getTopPerformers(),
            ['recent_orders' => $this->getRecentOrders()]
        );
    }

    /**
     * Get user count statistics
     */
    protected function getUserCounts(): array
    {
        return [
            'total_farmers' => Farmer::count(),
            'total_buyers' => Buyer::count(),
        ];
    }

    /**
     * Get order statistics
     */
    protected function getOrderStatistics(): array
    {
        return [
            'pending_orders_count' => Order::pending()->count(),
            'processing_orders_count' => Order::processing()->count(),
            'delivery_started_orders_count' => Order::deliveryStarted()->count(),
            'completed_orders_count' => Order::completed()->count(),
            'farmer_cancelled_orders_count' => Order::farmerCancelled()->count(),
            'buyer_cancelled_orders_count' => Order::buyerCancelled()->count(),
            'total_orders' => Order::count()
        ];
    }

    /**
     * Get revenue statistics
     */
    protected function getRevenueStatistics(): array
    {
        $completedOrdersTotal = Order::completed()->sum('total_amount');
        
        return [
            'shipping_revenue' => $completedOrdersTotal * 0.05,
            'total_sales' => $completedOrdersTotal,
        ];
    }

    /**
     * Get top performing buyers and farmers
     */
    protected function getTopPerformers(): array
    {
        return [
            'top_buyers' => Buyer::withCount('orders')
                ->orderByDesc('orders_count')
                ->limit(3)
                ->get(),
            'top_farmers' => Farmer::withCount('orders')
                ->orderByDesc('orders_count')
                ->limit(3)
                ->get(),
        ];
    }

    /**
     * Get recent orders
     */
    protected function getRecentOrders()
    {
        return Order::with(['buyer', 'farmer'])
            ->latest()
            ->limit(5)
            ->get();
    }

     /**
     * Update admin account details
     */
    public function updateAccount(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $validated = $this->validateAccountUpdateRequest($request, $admin);
        
        $admin->update([
            'Username' => $validated['username'],
            'Email' => $validated['email']
        ]);

        return redirect()
            ->route('admin.account')
            ->with('success', 'Account updated successfully!');
    }
    
    /**
     * Validate account update request
     */
    protected function validateAccountUpdateRequest(Request $request, Admin $admin): array
    {
        return $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('admin', 'Username')->ignore($admin->AdminID, 'AdminID')
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                Rule::unique('admin', 'Email')->ignore($admin->AdminID, 'AdminID')
            ]
        ], $this->validationMessages());
    }

    /**
     * Get validation messages
     */
    protected function validationMessages(): array
    {
        return [
            'username.required' => 'Username is required',
            'username.min' => 'Username must be at least 3 characters',
            'username.max' => 'Username may not be greater than 255 characters',
            'username.regex' => 'Username may only contain letters, numbers, and underscores',
            'username.unique' => 'This username is already taken',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address with a proper domain (e.g., example@gmail.com)',
            'email.max' => 'Email may not be greater than 255 characters',
            'email.unique' => 'This email is already in use'
        ];
    }
}