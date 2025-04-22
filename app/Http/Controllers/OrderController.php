<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\FarmerSellingPaddyType;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display product details page with order form
     */
    public function showProductDetails($id)
    {
        $paddyListing = FarmerSellingPaddyType::with(['paddyType', 'farmer'])
            ->findOrFail($id);
            
        return view('buyer.product-details', compact('paddyListing'));
    }
    
    /**
     * Place a new order
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'listing_id' => 'required|exists:farmer_selling_paddy_types,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $listing = FarmerSellingPaddyType::findOrFail($validated['listing_id']);
        
        if ($validated['quantity'] > $listing->Quantity) {
            return back()->with('error', 'The requested quantity exceeds available stock.');
        }
        
        $order = $this->createOrder($listing, $validated['quantity']);
        
        return redirect()->route('buyer.orders')->with('success', 'Order placed successfully!');
    }
    
    /**
     * Display buyer's orders
     */
    public function listOrders()
    {
        $orders = Order::where('buyer_id', Auth::guard('buyer')->id())
            ->with(['paddyType', 'farmer'])
            ->latest()
            ->paginate(10);
            
        return view('buyer.orders', compact('orders'));
    }
    
    /**
     * Display detailed information about a specific order
     */
    public function showOrderDetails($id)
    {
        $order = Order::where('id', $id)
            ->where('buyer_id', Auth::guard('buyer')->id())
            ->with(['paddyType', 'farmer'])
            ->firstOrFail();
            
        return view('buyer.order-details', compact('order'));
    }

    /**
     * Display farmer's orders
     */
    public function farmerOrders(Request $request)
    {
        $orders = $this->getFilteredFarmerOrders($request);
        
        $this->checkQuantityAvailability($orders);
        
        return view('farmer.orders.index', compact('orders'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('farmer_id', Auth::guard('farmer')->id())
            ->firstOrFail();
        
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
        
        if ($order->status === $validated['status']) {
            return back()->with('info', 'Order status remains unchanged.');
        }
        
        if ($this->shouldCheckQuantity($order->status, $validated['status'])) {
            if (!$this->hasSufficientQuantity($order)) {
                return back()->with('error', $this->getInsufficientQuantityMessage($order));
            }
        }
        
        $order->status = $validated['status'];
        $order->save();
        
        if ($this->shouldProcessOrder($order->status)) {
            $this->processOrder($order);
            return back()->with('success', 'Order accepted and status updated to ' . ucfirst($order->status));
        }
        
        if ($order->status === 'cancelled') {
            return back()->with('success', 'Order has been declined successfully.');
        }
        
        return back()->with('success', 'Order status updated to ' . ucfirst($order->status));
    }
    
    // Helper methods
    private function createOrder($listing, $quantity)
    {
        return Order::create([
            'buyer_id' => Auth::guard('buyer')->id(),
            'farmer_id' => $listing->FarmerID,
            'paddy_type_id' => $listing->PaddyID,
            'price_per_kg' => $listing->PriceSelected,
            'quantity' => $quantity,
            'total_amount' => $quantity * $listing->PriceSelected,
            'status' => 'pending'
        ]);
    }
    private function getFilteredFarmerOrders(Request $request)
    {
        $query = Order::with(['buyer', 'paddyType'])->where('farmer_id', auth()->guard('farmer')->id());
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('buyer', function($q) use ($search) {
                      $q->where('FullName', 'like', "%{$search}%");
                  })
                  ->orWhereHas('paddyType', function($q) use ($search) {
                      $q->where('PaddyName', 'like', "%{$search}%");
                  });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return $query->latest()->get();
    }
    private function checkQuantityAvailability($orders)
    {
        foreach ($orders as $order) {
            if ($order->status === 'pending') {
                $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)>where('PaddyID', $order->paddy_type_id)->first();
                $order->has_sufficient_quantity = $listing ? ($listing->Quantity >= $order->quantity) : false;
                $order->available_quantity = $listing ? $listing->Quantity : 0;
            }
        }
    }
    private function shouldCheckQuantity($oldStatus, $newStatus)
    {
        return $oldStatus === 'pending' && in_array($newStatus, ['processing', 'completed']);
    }
    private function hasSufficientQuantity($order)
    {
        $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)->where('PaddyID', $order->paddy_type_id)->first();
        return $listing && $order->quantity <= $listing->Quantity;
    }
    private function getInsufficientQuantityMessage($order)
    {
        $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)->where('PaddyID', $order->paddy_type_id)->first();
        if (!$listing) {
            return 'This paddy listing no longer exists. You cannot accept this order.';
        }
        return 'You don\'t have enough quantity to accept this order. ' .
               'Required: ' . $order->quantity . 'kg, Available: ' . $listing->Quantity . 'kg. ' .
               'Please update your listing quantity or decline this order.';
    }
    private function shouldProcessOrder($status)
    {
        return in_array($status, ['processing', 'completed']);
    }
    private function processOrder($order)
    {
        $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)->where('PaddyID', $order->paddy_type_id)->first();
        if (!$listing) return;
        $listing->Quantity -= $order->quantity;
        if ($listing->Quantity <= 0) {
            $this->handleZeroQuantity($listing, $order);
        } else {
            $listing->save();
        }
    }
    private function handleZeroQuantity($listing, $order)
    {
        $pendingOrdersExist = Order::where('farmer_id', $order->farmer_id)->where('paddy_type_id', $order->paddy_type_id)->where('status', 'pending')->exists(); 
        if (!$pendingOrdersExist) {
            $listing->delete();
        } else {
            $listing->Quantity = 0;
            $listing->save();
        }
    }
}