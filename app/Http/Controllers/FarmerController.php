<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\PaddyType;
use App\Models\FarmerSellingPaddyType;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    /**
     * Display all farmers (admin view)
     */
    public function index()
    {
        return view('admin.farmer.index', [
            'farmers' => Farmer::all()
        ]);
    }

    /**
     * Display farmer dashboard
     */
    public function dashboard()
    {
        $farmer = auth('farmer')->user();
        
        return view('farmer.dashboard', [
            'paddyTypes' => PaddyType::all(),
            'sellingPaddyTypes' => $this->getFarmerPaddyListings($farmer),
            'stats' => $this->getDashboardStatistics($farmer)
        ]);
    }

    /**
     * Show form for creating new paddy listing
     */
    public function create()
    {
        return view('farmer.FarmerPaddyListingForm', [
            'paddyTypes' => PaddyType::all()
        ]);
    }

    /**
     * Store new paddy listing
     */
    public function store(Request $request)
    {
        $validated = $this->validatePaddyListingRequest($request);
        
        FarmerSellingPaddyType::create($validated);
        
        return redirect()->route('farmer.dashboard')
            ->with('success', 'Paddy listed successfully!');
    }

    /**
     * Show form for editing paddy listing
     */
    public function edit($id)
    {
        $paddyListing = $this->getPaddyListing($id);
        $this->authorizeListingAccess($paddyListing);

        return view('farmer.FarmerPaddyListingEdit', [
            'paddyListing' => $paddyListing,
            'paddyTypes' => PaddyType::all()
        ]);
    }

    /**
     * Update paddy listing
     */
    public function update(Request $request, $id)
    {
        $paddyListing = $this->getPaddyListing($id);
        $this->authorizeListingAccess($paddyListing);

        $validated = $this->validatePaddyListingRequest($request, false);
        $paddyListing->update($validated);

        return redirect()->route('farmer.dashboard')
            ->with('success', 'Paddy listing updated successfully!');
    }

    /**
     * Delete paddy listing
     */
    public function destroy($id)
    {
        $paddyListing = $this->getPaddyListing($id);
        $this->authorizeListingAccess($paddyListing);

        $paddyListing->delete();
        return redirect()->route('farmer.dashboard')
            ->with('success', 'Paddy listing deleted successfully!');
    }

    /**
     * Delete farmer (admin only)
     */
    public function destroyFarmer($id)
    {
        $farmer = Farmer::findOrFail($id);
        $farmer->delete();
        
        return redirect()->route('admin.farmer.index')
            ->with('success', 'Farmer deleted successfully.');
    }

    // ==================== Protected Helper Methods ====================

    /**
     * Get dashboard statistics for farmer
     */
    protected function getDashboardStatistics(Farmer $farmer)
    {
        $orderStatusCounts = $this->getOrderStatusCounts($farmer);
        $statusConfigs = $this->getStatusConfigurations();

        return [
            'order_stats' => $this->getOrderStatistics($farmer),
            'revenue_stats' => $this->getRevenueStatistics($farmer),
            'listing_stats' => $this->getListingStatistics($farmer),
            'sales_chart' => $this->getSalesChartData($farmer),
            'paddy_sales' => $this->getPaddySalesData($farmer),
            'recent_orders' => $this->getRecentOrders($farmer),
            'order_status_counts' => $this->combineCancelledStatuses($orderStatusCounts),
            'detailed_order_status_counts' => $orderStatusCounts,
            'status_configs' => $statusConfigs,
            'status_colors' => array_column($statusConfigs, 'color', 'status'),
            'status_icons' => array_column($statusConfigs, 'icon', 'status'),
            'status_texts' => array_column($statusConfigs, 'text', 'status'),
        ];
    }

    /**
     * Get order status counts for farmer
     */
    protected function getOrderStatusCounts(Farmer $farmer)
    {
        return Order::where('farmer_id', $farmer->FarmerID)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    /**
     * Get status configurations
     */
    protected function getStatusConfigurations()
    {
        return [
            'pending' => [
                'text' => 'Pending',
                'color' => 'amber',
                'icon' => 'fa-clock fa-spin',
                'chart_color' => 'rgba(255, 193, 7, 0.6)'
            ],
            'processing' => [
                'text' => 'Processing',
                'color' => 'emerald',
                'icon' => 'fa-gears',
                'chart_color' => 'rgba(31, 69, 41, 0.6)'
            ],
            'delivery_started' => [
                'text' => 'Delivery Started',
                'color' => 'green',
                'icon' => 'fa-truck-fast',
                'chart_color' => 'rgba(76, 175, 80, 0.6)'
            ],
            'delivered' => [
                'text' => 'Delivered',
                'color' => 'lime',
                'icon' => 'fa-person-circle-check',
                'chart_color' => 'rgba(139, 195, 74, 0.6)'
            ],
            'completed' => [
                'text' => 'Completed',
                'color' => 'green',
                'icon' => 'fa-circle-check',
                'chart_color' => 'rgba(139, 195, 74, 0.6)'
            ],
            'buyer_cancelled' => [
                'text' => 'Cancelled by Buyer',
                'color' => 'red',
                'icon' => 'fa-ban',
                'chart_color' => 'rgba(244, 67, 54, 0.6)'
            ],
            'farmer_cancelled' => [
                'text' => 'Declined by You',
                'color' => 'red',
                'icon' => 'fa-ban',
                'chart_color' => 'rgba(220, 53, 69, 0.6)'
            ],
            'cancelled' => [  
                'text' => 'Cancelled',
                'color' => 'red',
                'icon' => 'fa-ban',
                'chart_color' => 'rgba(244, 67, 54, 0.6)'
            ]
        ];
    }

    /**
     * Combine cancelled status counts
     */
    protected function combineCancelledStatuses(array $statusCounts)
    {
        $combined = [];
        foreach ($statusCounts as $status => $count) {
            if (in_array($status, ['buyer_cancelled', 'farmer_cancelled'])) {
                $combined['cancelled'] = ($combined['cancelled'] ?? 0) + $count;
            } else {
                $combined[$status] = $count;
            }
        }
        return $combined;
    }

    /**
     * Get order statistics
     */
    protected function getOrderStatistics(Farmer $farmer)
    {
        return [
            'total_orders' => Order::where('farmer_id', $farmer->FarmerID)->count(),
            'pending_orders' => Order::where('farmer_id', $farmer->FarmerID)
                                ->where('status', 'pending')->count(),
        ];
    }

    /**
     * Get revenue statistics
     */
    protected function getRevenueStatistics(Farmer $farmer)
    {
        return [
            'total_revenue' => Order::where('farmer_id', $farmer->FarmerID)
                                ->whereIn('status', ['completed', 'delivered'])
                                ->sum('total_amount'),
            'monthly_revenue' => Order::where('farmer_id', $farmer->FarmerID)
                                ->whereIn('status', ['completed', 'delivered'])
                                ->where('created_at', '>=', Carbon::now()->subDays(30))
                                ->sum('total_amount'),
        ];
    }

    /**
     * Get listing statistics
     */
    protected function getListingStatistics(Farmer $farmer)
    {
        return [
            'active_listings' => FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
                                ->where('Quantity', '>', 0)
                                ->count(),
            'low_stock_listings' => FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
                                ->where('Quantity', '<', 10)
                                ->where('Quantity', '>', 0)
                                ->count(),
        ];
    }

    /**
     * Get sales chart data
     */
    protected function getSalesChartData(Farmer $farmer)
    {
        $sales = Order::where('farmer_id', $farmer->FarmerID)
            ->whereIn('status', ['completed', 'delivered'])
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, SUM(total_amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->take(6)
            ->get();

        $labels = [];
        $data = [];

        foreach ($sales as $sale) {
            $date = Carbon::create($sale->year, $sale->month, 1);
            $labels[] = $date->format('M Y');
            $data[] = $sale->total;
        }

        return compact('labels', 'data');
    }

    /**
     * Get paddy sales data
     */
    protected function getPaddySalesData(Farmer $farmer)
    {
        $paddySales = FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
            ->with(['paddyType', 'orders' => function($query) {
                $query->whereIn('status', ['completed', 'delivered']);
            }])
            ->get()
            ->map(function($paddy) {
                return [
                    'name' => $paddy->paddyType->PaddyName,
                    'total_quantity' => $paddy->orders->sum('quantity'),
                    'total_revenue' => $paddy->orders->sum('total_amount')
                ];
            });

        return [
            'labels' => $paddySales->pluck('name'),
            'quantities' => $paddySales->pluck('total_quantity'),
            'revenues' => $paddySales->pluck('total_revenue')
        ];
    }

    /**
     * Get recent orders
     */
    protected function getRecentOrders(Farmer $farmer)
    {
        $orders = Order::where('farmer_id', $farmer->FarmerID)
            ->with('paddyType')
            ->latest()
            ->take(3)
            ->get();

        $statusConfigs = [
            'pending' => ['text' => 'Pending', 'color' => 'yellow', 'icon' => 'fa-regular fa-clock fa-spin'],
            'processing' => ['text' => 'Processing', 'color' => 'blue', 'icon' => 'fa-solid fa-gears'],
            'delivery_started' => ['text' => 'Delivery Started', 'color' => 'purple', 'icon' => 'fa-solid fa-truck-fast'],
            'delivered' => ['text' => 'Delivered', 'color' => 'green', 'icon' => 'fa-solid fa-person-circle-check'],
            'completed' => ['text' => 'Completed', 'color' => 'green', 'icon' => 'fa-solid fa-circle-check'],
            'buyer_cancelled' => ['text' => 'Cancelled by Buyer', 'color' => 'red', 'icon' => 'fa-solid fa-ban'],
            'farmer_cancelled' => ['text' => 'Declined by You', 'color' => 'red', 'icon' => 'fa-solid fa-ban']
        ];

        return $orders->map(function($order) use ($statusConfigs) {
            $statusConfig = $statusConfigs[$order->status] ?? 
                         ['text' => 'Unknown', 'color' => 'gray', 'icon' => 'fa-solid fa-circle-question'];
            
            return [
                'title' => 'Order #'.$order->id.' - '.$order->paddyType->PaddyName,
                'description' => $order->quantity.'bu for Rs '.number_format($order->total_amount, 2),
                'time' => $order->created_at->diffForHumans(),
                'status_text' => $statusConfig['text'],
                'status_color' => $statusConfig['color'],
                'status_icon' => $statusConfig['icon'],
                'status' => $order->status 
            ];
        });
    }

    /**
     * Get farmer's paddy listings
     */
    protected function getFarmerPaddyListings(Farmer $farmer)
    {
        return FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
            ->with('paddyType')
            ->get();
    }

    /**
     * Validate paddy listing request
     */
    protected function validatePaddyListingRequest(Request $request, $includeFarmerId = true)
    {
        $rules = [
            'PaddyID' => 'required|exists:paddy_types,PaddyID',
            'PriceSelected' => 'required|numeric|min:0',
            'Quantity' => 'required|numeric|min:1',
        ];

        if ($includeFarmerId) {
            $rules['FarmerID'] = 'required|exists:farmers,FarmerID';
        }

        return $request->validate($rules);
    }

    /**
     * Get paddy listing with authorization check
     */
    protected function getPaddyListing($id)
    {
        return FarmerSellingPaddyType::findOrFail($id);
    }

    /**
     * Authorize access to paddy listing
     */
    protected function authorizeListingAccess(FarmerSellingPaddyType $paddyListing)
    {
        if ($paddyListing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')
                ->with('error', 'You are not authorized to access this listing.');
        }
    }
}