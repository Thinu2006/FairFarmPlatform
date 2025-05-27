<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    /**
     * Display a paginated list of orders with optional filters
     */
    public function index(Request $request)
    {
        $orders = $this->buildOrderQuery($request)
            ->paginate(10);

        return view('admin.orders.index', [
            'orders' => $orders,
            'status' => $request->input('status')
        ]);
    }

    /**
     * Display details of a specific order
     */
    public function show($id)
    {
        $order = $this->getOrderWithRelations($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Start the delivery process for an order
     */
    public function startDelivery($id)
    {
        $order = Order::findOrFail($id);

        if (!$order->isProcessing()) {
            return $this->redirectWithError(
                'Order must be accepted by farmer before delivery can start'
            );
        }

        $order->markAsDeliveryStarted();
        return $this->redirectWithSuccess('Delivery process started successfully');
    }
    /**
     * Mark an order as delivered
     */
    public function completeDelivery($id)
    {
        $order = Order::findOrFail($id);

        if (!$order->isDeliveryStarted()) {
            return $this->redirectWithError(
                'Delivery must be started before it can be completed'
            );
        }

        $order->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);
        
        $this->logDeliveryCompletion($order);

        return $this->redirectWithSuccess('Order has been successfully delivered');
    }

    /**
     * Update order status (generic method)
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,declined,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->updateStatus($validated['status']);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully');
    }

    /**
     * Prevent order deletion (safety measure)
     */
    public function preventDestroy($id)
    {
        return $this->redirectWithError('Deleting orders is not allowed');
    }

    /**
     * Prevent status update (safety measure)
     */
    public function preventStatusUpdate($id)
    {
        return $this->redirectWithError('Updating order status is not allowed for admin');
    }

    /**
     * Build the base order query with filters
     */
    protected function buildOrderQuery(Request $request)
    {
        return Order::with(['buyer', 'farmer', 'paddyType'])
            ->when($request->input('query'), function ($query) use ($request) {
                return $this->applySearchFilter($query, $request->input('query'));
            })
            ->when($request->input('status'), function ($query) use ($request) {
                return $this->applyStatusFilter($query, $request->input('status'));
            })
            ->latest();
    }

    /**
     * Apply search filter to the query
     */
    protected function applySearchFilter($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->whereHas('buyer', function($q) use ($searchTerm) {
                $q->where('FullName', 'like', "%{$searchTerm}%");
            })
            ->orWhereHas('farmer', function($q) use ($searchTerm) {
                $q->where('FullName', 'like', "%{$searchTerm}%");
            })
            ->orWhereHas('paddyType', function($q) use ($searchTerm) {
                $q->where('PaddyName', 'like', "%{$searchTerm}%");
            });
        });
    }

    /**
     * Apply status filter to the query
     */
    protected function applyStatusFilter($query, $status)
    {
        return $status === 'declined'
            ? $query->whereIn('status', ['buyer_cancelled', 'farmer_cancelled'])
            : $query->where('status', $status);
    }

    /**
     * Get order with relations
     */
    protected function getOrderWithRelations($id)
    {
        return Order::with(['buyer', 'farmer', 'paddyType'])
            ->findOrFail($id);
    }

    /**
     * Redirect back with success message
     */
    protected function redirectWithSuccess(string $message)
    {
        return redirect()->back()->with('success', $message);
    }

    /**
     * Redirect back with error message
     */
    protected function redirectWithError(string $message)
    {
        return redirect()->back()->with('error', $message);
    }
    // Add this method to your AdminOrderController
    protected function logDeliveryCompletion(Order $order)
    {
        Log::info('Order delivered', [
            'order_id' => $order->id,
            'buyer_id' => $order->buyer_id,
            'farmer_id' => $order->farmer_id,
            'amount' => $order->total_amount,
            'status' => $order->status
        ]);
    }
}