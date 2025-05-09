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
    public function index()
    {
        $farmers = Farmer::all();
        return view('admin.farmer.index', ['farmers' => $farmers]);
    }

    /**
     * Display the farmer dashboard.
     */
    public function dashboard()
    {
        $farmer = auth('farmer')->user();

        // Get order status counts
        $orderStatusCounts = Order::where('farmer_id', $farmer->FarmerID)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Define status configurations
        $statusConfigs = [
            'pending' => [
                'text' => 'Pending',
                'color' => 'amber',  // Matches rgba(255, 193, 7, 0.6)
                'icon' => 'fa-clock fa-spin',
                'chart_color' => 'rgba(255, 193, 7, 0.6)'
            ],
            'processing' => [
                'text' => 'Processing',
                'color' => 'emerald',  // Matches rgba(31, 69, 41, 0.6)
                'icon' => 'fa-gears',
                'chart_color' => 'rgba(31, 69, 41, 0.6)'
            ],
            'delivery_started' => [
                'text' => 'Delivery Started',
                'color' => 'green',  // Matches rgba(76, 175, 80, 0.6)
                'icon' => 'fa-truck-fast',
                'chart_color' => 'rgba(76, 175, 80, 0.6)'
            ],
            'delivered' => [
                'text' => 'Delivered',
                'color' => 'lime',  // Matches rgba(139, 195, 74, 0.6)
                'icon' => 'fa-person-circle-check',
                'chart_color' => 'rgba(139, 195, 74, 0.6)'
            ],
            'completed' => [
                'text' => 'Completed',
                'color' => 'green',  // Similar to delivered
                'icon' => 'fa-circle-check',
                'chart_color' => 'rgba(139, 195, 74, 0.6)'
            ],
            'cancelled' => [
                'text' => 'Cancelled',
                'color' => 'red',  // Matches rgba(244, 67, 54, 0.6)
                'icon' => 'fa-ban',
                'chart_color' => 'rgba(244, 67, 54, 0.6)'
            ]
        ];    

        // Dashboard statistics
        $stats = [
            'total_orders' => Order::where('farmer_id', $farmer->FarmerID)->count(),
            'pending_orders' => Order::where('farmer_id', $farmer->FarmerID)
                                ->where('status', 'pending')->count(),
            'total_revenue' => Order::where('farmer_id', $farmer->FarmerID)
                                ->whereIn('status', ['completed', 'delivered'])
                                ->sum('total_amount'),
            'monthly_revenue' => Order::where('farmer_id', $farmer->FarmerID)
                                ->whereIn('status', ['completed', 'delivered'])
                                ->where('created_at', '>=', Carbon::now()->subDays(30))
                                ->sum('total_amount'),
            'active_listings' => FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
                                ->where('Quantity', '>', 0)
                                ->count(),
            'low_stock_listings' => FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
                                ->where('Quantity', '<', 10)
                                ->where('Quantity', '>', 0)
                                ->count(),
            'sales_chart' => $this->getSalesChartData($farmer),
            'paddy_sales' => $this->getPaddySalesData($farmer),
            'recent_orders' => $this->getRecentOrders($farmer),
            'order_status_counts' => $orderStatusCounts,
            'status_colors' => array_column($statusConfigs, 'color', 'status'),
            'status_icons' => array_column($statusConfigs, 'icon', 'status'),
            'status_texts' => array_column($statusConfigs, 'text', 'status'),
            'status_configs' => $statusConfigs,
        ];

        // Fetch all paddy types for the dropdown
        $paddyTypes = PaddyType::all();

        // Fetch the paddy listings for the authenticated farmer
        $sellingPaddyTypes = FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
            ->with('paddyType')
            ->get();

        return view('farmer.dashboard', compact('paddyTypes', 'sellingPaddyTypes', 'stats'));
    }

    private function getSalesChartData($farmer)
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

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getPaddySalesData($farmer)
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

    private function getRecentOrders($farmer)
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
            'cancelled' => ['text' => 'Cancelled', 'color' => 'red', 'icon' => 'fa-solid fa-ban']
        ];

        return $orders->map(function($order) use ($statusConfigs) {
            $statusConfig = $statusConfigs[$order->status] ?? 
                           ['text' => 'Unknown', 'color' => 'gray', 'icon' => 'fa-solid fa-circle-question'];
            
            return [
                'title' => 'Order #'.$order->id.' - '.$order->paddyType->PaddyName,
                'description' => $order->quantity.'kg for Rs '.number_format($order->total_amount, 2),
                'time' => $order->created_at->diffForHumans(),
                'status_text' => $statusConfig['text'],
                'status_color' => $statusConfig['color'],
                'status_icon' => $statusConfig['icon']
            ];
        });
    }

    public function destroyFarmer($id)
    {
        $farmer = Farmer::findOrFail($id);
        $farmer->delete();
        return redirect()->route('admin.farmer.index')->with('success', 'Farmer deleted successfully.');
    }

    /**
     * Display the form for listing a new paddy type.
     */
    public function create()
    {
        $paddyTypes = PaddyType::all();
        return view('farmer.FarmerPaddyListingForm', compact('paddyTypes'));
    }

    /**
     * Store a newly listed paddy type.
     */
    public function store(Request $request)
    {
        $request->validate([
            'FarmerID' => 'required|exists:farmers,FarmerID',
            'PaddyID' => 'required|exists:paddy_types,PaddyID',
            'PriceSelected' => 'required|numeric|min:0',
            'Quantity' => 'required|numeric|min:1',
        ]);

        FarmerSellingPaddyType::create([
            'FarmerID' => $request->FarmerID,
            'PaddyID' => $request->PaddyID,
            'PriceSelected' => $request->PriceSelected,
            'Quantity' => $request->Quantity,
        ]);

        return redirect()->route('farmer.dashboard')->with('success', 'Paddy listed successfully!');
    }

    /**
     * Display the form for editing a paddy listing.
     */
    public function edit($id)
    {
        $paddyListing = FarmerSellingPaddyType::findOrFail($id);

        if ($paddyListing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')->with('error', 'You are not authorized to edit this listing.');
        }

        $paddyTypes = PaddyType::all();
        return view('farmer.FarmerPaddyListingEdit', compact('paddyListing', 'paddyTypes'));
    }

    /**
     * Update a paddy listing.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'PaddyID' => 'required|exists:paddy_types,PaddyID',
            'PriceSelected' => 'required|numeric|min:0',
            'Quantity' => 'required|numeric|min:1',
        ]);

        $paddyListing = FarmerSellingPaddyType::findOrFail($id);

        if ($paddyListing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')->with('error', 'You are not authorized to update this listing.');
        }

        $paddyListing->update([
            'PaddyID' => $request->PaddyID,
            'PriceSelected' => $request->PriceSelected,
            'Quantity' => $request->Quantity,
        ]);

        return redirect()->route('farmer.dashboard')->with('success', 'Paddy listing updated successfully!');
    }

    /**
     * Delete a paddy listing.
     */
    public function destroy($id)
    {
        $paddyListing = FarmerSellingPaddyType::findOrFail($id);

        if ($paddyListing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')->with('error', 'You are not authorized to delete this listing.');
        }

        $paddyListing->delete();
        return redirect()->route('farmer.dashboard')->with('success', 'Paddy listing deleted successfully!');
    }
}