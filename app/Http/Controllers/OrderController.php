<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\FarmerSellingPaddyType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        // Validate the request
        $request->validate([
            'listing_id' => 'required|exists:farmer_selling_paddy_types,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        // Get the paddy listing
        $listing = FarmerSellingPaddyType::findOrFail($request->listing_id);
        
        // Check if quantity is available
        if ($request->quantity > $listing->Quantity) {
            return back()->with('error', 'The requested quantity exceeds available stock.');
        }
        
        // Calculate total amount
        $totalAmount = $request->quantity * $listing->PriceSelected;
        
        // Create order
        $order = new Order([
            'buyer_id' => Auth::guard('buyer')->id(),
            'farmer_id' => $listing->FarmerID,
            'paddy_type_id' => $listing->PaddyID,
            'price_per_kg' => $listing->PriceSelected,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);
        
        $order->save();
        
        Log::info('Order placed', [
            'buyer_id' => Auth::guard('buyer')->id(),
            'order_id' => $order->id,
            'paddy_type' => $listing->paddyType->PaddyName,
            'quantity' => $request->quantity,
            'total' => $totalAmount
        ]);
        
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
        $query = Order::with(['buyer', 'paddyType'])
            ->where('farmer_id', auth()->guard('farmer')->id());
        
        // Filter by search term
        if ($request->has('search') && !empty($request->search)) {
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
        
        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->latest()->get();
        
        // Check quantity availability for pending orders
        foreach ($orders as $order) {
            if ($order->status === 'pending') {
                $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)
                    ->where('PaddyID', $order->paddy_type_id)
                    ->first();
                
                if ($listing) {
                    $order->has_sufficient_quantity = $listing->Quantity >= $order->quantity;
                    $order->available_quantity = $listing->Quantity;
                } else {
                    $order->has_sufficient_quantity = false;
                    $order->available_quantity = 0;
                }
            }
        }

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
        
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
        
        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        // Don't process if status didn't change
        if ($oldStatus == $newStatus) {
            return back()->with('info', 'Order status remains unchanged.');
        }
        
        // If farmer is trying to accept an order, check available quantity first
        if ($oldStatus == 'pending' && ($newStatus == 'processing' || $newStatus == 'completed')) {
            // Get the current listing
            $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)
                        ->where('PaddyID', $order->paddy_type_id)
                        ->first();
            
            if ($listing) {
                // Check if there's enough quantity
                if ($order->quantity > $listing->Quantity) {
                    Log::warning('Insufficient quantity to accept order', [
                        'order_id' => $order->id,
                        'required_quantity' => $order->quantity,
                        'available_quantity' => $listing->Quantity
                    ]);
                    
                    return back()->with('error', 
                        'You don\'t have enough quantity to accept this order. 
                        Required: ' . $order->quantity . 'kg, Available: ' . $listing->Quantity . 'kg. 
                        Please update your listing quantity or decline this order.');
                }
            } else {
                // The listing has been deleted
                return back()->with('error', 'This paddy listing no longer exists. You cannot accept this order.');
            }
        }
        
        $order->status = $newStatus;
        $order->save();
        
        // Process accepted orders (existing logic)
        if (($oldStatus == 'pending') && ($newStatus == 'processing' || $newStatus == 'completed')) {
            $listing = FarmerSellingPaddyType::where('FarmerID', $order->farmer_id)
                        ->where('PaddyID', $order->paddy_type_id)
                        ->first();
            
            if ($listing) {
                $listing->Quantity -= $order->quantity;
                
                // Check if quantity is now zero or negative
                if ($listing->Quantity <= 0) {
                    // Check if there are any pending orders for this paddy type from this farmer
                    $pendingOrdersExist = Order::where('farmer_id', $order->farmer_id)
                        ->where('paddy_type_id', $order->paddy_type_id)
                        ->where('status', 'pending')
                        ->exists();

                    if (!$pendingOrdersExist) {
                        // Only delete the listing if there are no pending orders
                        Log::info('Removing listing due to zero quantity and no pending orders', [
                            'listing_id' => $listing->id,
                            'paddy_type' => $order->paddyType->PaddyName,
                            'farmer_id' => $listing->FarmerID,
                            'note' => 'This listing will be removed for all users including admin'
                        ]);
                        
                        $listing->delete();
                    } else {
                        // Set quantity to 0 but keep the listing since there are pending orders
                        $listing->Quantity = 0;
                        $listing->save();
                        
                        Log::info('Listing quantity is zero but kept due to pending orders', [
                            'listing_id' => $listing->id,
                            'paddy_type' => $order->paddyType->PaddyName,
                            'farmer_id' => $listing->FarmerID
                        ]);
                    }
                } else {
                    $listing->save();
                }
                
                Log::info('Order confirmed and quantity reduced', [
                    'order_id' => $order->id,
                    'quantity' => $order->quantity,
                    'new_quantity' => $listing->Quantity
                ]);
            }
            
            return back()->with('success', 'Order accepted and status updated to ' . ucfirst($newStatus));
        }
        
        // Handle cancelled orders
        if ($newStatus == 'cancelled') {
            Log::info('Order declined by farmer', [
                'order_id' => $order->id,
                'farmer_id' => Auth::guard('farmer')->id(),
                'previous_status' => $oldStatus
            ]);
            
            return back()->with('success', 'Order has been declined successfully.');
        }
        
        // General success message for other status changes
        return back()->with('success', 'Order status updated to ' . ucfirst($newStatus));
    }
    
}
