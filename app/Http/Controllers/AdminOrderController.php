<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Farmer;
use App\Models\Buyer;
use App\Models\PaddyType;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');
        
        $orders = Order::with(['buyer', 'farmer', 'paddyType'])
            ->when($query, function ($q) use ($query) {
                return $q->whereHas('buyer', function($q) use ($query) {
                    $q->where('FullName', 'like', '%' . $query . '%');
                })->orWhereHas('farmer', function($q) use ($query) {
                    $q->where('FullName', 'like', '%' . $query . '%');
                })->orWhereHas('paddyType', function($q) use ($query) {
                    $q->where('PaddyName', 'like', '%' . $query . '%');
                });
            })
            ->when($status, function ($q) use ($status) {
                // Map the user-friendly status to database status
                if ($status == 'declined') {
                    return $q->where('status', 'cancelled');
                } else {
                    // 'completed' and 'pending' remain the same
                    return $q->where('status', $status);
                }
            })
            ->latest()
            ->paginate(10);
        
        return view('admin.orders.index', compact('orders', 'status'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['buyer', 'farmer', 'paddyType'])
            ->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,declined,completed,cancelled'
        ]);
        
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully');
    }

    /**
     * Remove the specified order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }

    /**
     * This method handles delete requests but prevents actual deletion
     * since admins should only view orders.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function preventDestroy($id)
    {
        return redirect()->back()->with('error', 'Deleting orders is not allowed.');
    }

    /**
     * This method prevents admins from updating order status.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function preventStatusUpdate($id)
    {
        return redirect()->back()->with('error', 'Updating order status is not allowed for administrators.');
    }
}
