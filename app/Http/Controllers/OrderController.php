<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\FarmerSellingPaddyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display product details page with order form
     */
    public function showProductDetails($id)
    {
        $paddyListing = $this->getPaddyListingWithDetails($id);
        return view('buyer.product-details', compact('paddyListing'));
    }
    
    /**
     * Place a new order
     */
    public function placeOrder(Request $request)
    {
        $validated = $this->validateOrderRequest($request);
        $listing = $this->getPaddyListing($validated['listing_id']);
        
        if (!$this->hasSufficientQuantity($listing, $validated['quantity'])) {
            return back()->with('error', 'The requested quantity exceeds available stock.');
        }
        
        $this->createOrder($listing, $validated['quantity']);
        
        return redirect()->route('buyer.orders')
            ->with('success', 'Order placed successfully!');
    }
    
    /**
     * Display buyer's orders
     */
    public function listOrders()
    {
        $orders = $this->getBuyerOrders();
        return view('buyer.orders', compact('orders'));
    }
    
    /**
     * Display detailed information about a specific order
     */
    public function showOrderDetails($id)
    {
        $order = $this->getBuyerOrderDetails($id);
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
        $order = $this->getFarmerOrder($id);
        $validated = $this->validateStatusUpdateRequest($request);
        
        if ($this->isOrderCancelledByBuyer($order)) {
            return back()->with('error', 'This order was cancelled by the buyer and cannot be modified.');
        }

        if ($this->isStatusUnchanged($order, $validated['status'])) {
            return back()->with('info', 'Order status remains unchanged.');
        }

        return $this->processStatusUpdate($order, $validated['status']);
    }
    
    /**
     * Confirm order receipt by buyer
     */
    public function receiveOrder($id)
    {
        $order = $this->getBuyerOrder($id);
        $this->markOrderAsCompleted($order);
        
        return redirect()->back()
            ->with('success', 'Order has been received');
    }
    
    /**
     * Cancel an order by buyer
     */
    public function cancelOrder($id)
    {
        $order = $this->getPendingBuyerOrder($id);
        $this->markOrderAsCancelled($order);
        
        return redirect()->back()
            ->with('success', 'Order successfully cancelled.');
    }

    // ==================== Protected Helper Methods ====================

    protected function getPaddyListingWithDetails($id)
    {
        return FarmerSellingPaddyType::with(['paddyType', 'farmer'])
            ->findOrFail($id);
    }

    protected function validateOrderRequest(Request $request)
    {
        return $request->validate([
            'listing_id' => 'required|exists:farmer_selling_paddy_types,id',
            'quantity' => 'required|integer|min:1',
        ]);
    }

    protected function getPaddyListing($id)
    {
        return FarmerSellingPaddyType::findOrFail($id);
    }

    protected function hasSufficientQuantity($listing, $quantity)
    {
        return $quantity <= $listing->Quantity;
    }

    protected function createOrder($listing, $quantity)
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

    protected function getBuyerOrders()
    {
        return Order::where('buyer_id', Auth::guard('buyer')->id())
            ->with(['paddyType', 'farmer'])
            ->latest()
            ->paginate(10);
    }

    protected function getBuyerOrderDetails($id)
    {
        return Order::where('id', $id)
            ->where('buyer_id', Auth::guard('buyer')->id())
            ->with(['paddyType', 'farmer'])
            ->firstOrFail();
    }

    protected function getFilteredFarmerOrders(Request $request)
    {
        $query = Order::with(['buyer', 'paddyType'])
            ->where('farmer_id', auth()->guard('farmer')->id());

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', "%{$request->search}%")
                  ->orWhereHas('buyer', function($q) use ($request) {
                      $q->where('FullName', 'like', "%{$request->search}%");
                  })
                  ->orWhereHas('paddyType', function($q) use ($request) {
                      $q->where('PaddyName', 'like', "%{$request->search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest()->get();
    }

    protected function checkQuantityAvailability($orders)
    {
        foreach ($orders as $order) {
            if ($order->status === 'pending') {
                $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)
                    ->where('PaddyID', $order->paddy_type_id)
                    ->first();
                
                $order->has_sufficient_quantity = $listing ? ($listing->Quantity >= $order->quantity) : false;
                $order->available_quantity = $listing ? $listing->Quantity : 0;
            }
        }
    }

    protected function getFarmerOrder($id)
    {
        return Order::where('id', $id)
            ->where('farmer_id', Auth::guard('farmer')->id())
            ->firstOrFail();
    }

    protected function validateStatusUpdateRequest(Request $request)
    {
        return $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
    }

    protected function isOrderCancelledByBuyer($order)
    {
        return $order->status === 'buyer_cancelled';
    }

    protected function isStatusUnchanged($order, $newStatus)
    {
        return $order->status === $newStatus;
    }

    protected function processStatusUpdate($order, $newStatus)
    {
        if ($newStatus === 'cancelled') {
            return $this->declineOrder($order);
        }

        if ($this->shouldCheckQuantity($order->status, $newStatus)) {
            if (!$this->hasSufficientQuantityForOrder($order)) {
                return back()->with('error', $this->getInsufficientQuantityMessage($order));
            }
        }

        $order->status = $newStatus;
        $order->save();
        
        if ($this->shouldProcessOrder($newStatus)) {
            $this->processOrder($order);
            return back()->with('success', 'Order accepted successfully!');
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($newStatus));
    }

    protected function declineOrder($order)
    {
        $order->update([
            'status' => 'farmer_cancelled', 
            'cancelled_by' => 'farmer',
            'cancelled_at' => now()
        ]);
        
        return back()->with('success', 'Order has been declined successfully.');
    }

    protected function shouldCheckQuantity($oldStatus, $newStatus)
    {
        return $oldStatus === 'pending' && in_array($newStatus, ['processing', 'completed']);
    }

    protected function hasSufficientQuantityForOrder($order)
    {
        $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)
            ->where('PaddyID', $order->paddy_type_id)
            ->first();
            
        return $listing && $order->quantity <= $listing->Quantity;
    }

    protected function getInsufficientQuantityMessage($order)
    {
        $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)
            ->where('PaddyID', $order->paddy_type_id)
            ->first();

        if (!$listing) {
            return 'This paddy listing no longer exists. You cannot accept this order.';
        }

        return 'You don\'t have enough quantity to accept this order. ' .
               'Required: ' . $order->quantity . 'kg, Available: ' . $listing->Quantity . 'kg. ' .
               'Please update your listing quantity or decline this order.';
    }

    protected function shouldProcessOrder($status)
    {
        return in_array($status, ['processing', 'completed']);
    }

    protected function processOrder($order)
    {
        $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)
            ->where('PaddyID', $order->paddy_type_id)
            ->first();

        if (!$listing) return;

        $listing->Quantity -= $order->quantity;
        
        if ($listing->Quantity <= 0) {
            $this->handleZeroQuantity($listing, $order);
        } else {
            $listing->save();
        }
    }

    protected function handleZeroQuantity($listing, $order)
    {
        $pendingOrdersExist = Order::where('farmer_id', $order->farmer_id)
            ->where('paddy_type_id', $order->paddy_type_id)
            ->where('status', 'pending')
            ->exists(); 

        if (!$pendingOrdersExist) {
            $listing->delete();
        } else {
            $listing->Quantity = 0;
            $listing->save();
        }
    }

    protected function getBuyerOrder($id)
    {
        return Order::findOrFail($id);
    }

    protected function markOrderAsCompleted($order)
    {
        $order->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    protected function getPendingBuyerOrder($id)
    {
        return Order::where('id', $id)
            ->where('buyer_id', Auth::guard('buyer')->id())
            ->where('status', 'pending')
            ->firstOrFail();
    }

    protected function markOrderAsCancelled($order)
    {
        $order->update([
            'status' => 'buyer_cancelled',
            'cancelled_by' => 'buyer',
            'cancelled_at' => now()
        ]);
    }
}