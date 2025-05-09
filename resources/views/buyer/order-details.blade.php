@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('buyer.orders') }}" class="text-green-600 hover:text-green-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to Orders
            </a>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Order #{{ $order->id }}</h1>
        
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <!-- Order Status Badge -->
                <div class="text-right">
                    @if($order->status == 'pending')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    @elseif($order->status == 'processing')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            Accepted
                        </span>
                    @elseif($order->status == 'delivery_started')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                            Delivery Started
                        </span>
                    @elseif($order->status == 'delivered')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Delivered
                        </span>
                    @elseif($order->status == 'completed')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Completed
                        </span>
                    @elseif($order->status == 'cancelled')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Declined
                        </span>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Order Information -->
                    <div>
                        <h3 class="text-xl font-semibold border-b pb-3 mb-4">Order Information</h3>
                        <table class="w-full text-left">
                            <tr>
                                <th class="py-2 text-gray-600">Order Date:</th>
                                <td class="py-2">{{ $order->created_at->format('F d, Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-gray-600">Paddy Type:</th>
                                <td class="py-2">{{ $order->paddyType->PaddyName }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-gray-600">Farmer:</th>
                                <td class="py-2">{{ $order->farmer->FullName }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-gray-600">Quantity:</th>
                                <td class="py-2">{{ number_format($order->quantity, 0) }} Kg</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-gray-600">Payment Method:</th>
                                <td class="py-2">Cash on Delivery</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-gray-600">Delivery Address:</th>
                                <td class="py-2">{{ $order->buyer->Address }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Price Details -->
                    <div>
                        <h3 class="text-xl font-semibold border-b pb-3 mb-4">Price Details</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Price Per Kg:</span>
                                <span class="font-medium">Rs {{ number_format($order->price_per_kg, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">{{ number_format($order->quantity, 0) }} Kg</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">Rs {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Shipping Fee (5%):</span>
                                <span class="font-medium">Rs {{ number_format($order->total_amount * 0.05, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-t border-gray-200 mt-2 pt-2">
                                <span class="text-gray-800 font-bold">Grand Total:</span>
                                <span class="text-gray-800 font-bold">Rs {{ number_format($order->total_amount * 1.05, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Timeline Section -->
                <!-- Order Timeline Section -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Order Timeline</h3>
                    
                    <div class="relative border-l-2 border-gray-200 ml-3">
                        <!-- Order Placed -->
                        <div class="mb-6 relative">
                            <div class="absolute -left-3 mt-1.5 w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="text-sm font-medium text-gray-900">Order Placed</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        
                        <!-- Order Accepted -->
                        @if(in_array($order->status, ['processing', 'delivery_started', 'delivered', 'completed']))
                        <div class="mb-6 relative">
                            <div class="absolute -left-3 mt-1.5 w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="text-sm font-medium text-gray-900">Order Accepted by Farmer</p>
                                <p class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Delivery Started -->
                        @if(in_array($order->status, ['delivery_started', 'delivered', 'completed']))
                        <div class="mb-6 relative">
                            <div class="absolute -left-3 mt-1.5 w-6 h-6 rounded-full bg-purple-500 text-white flex items-center justify-center">
                                <i class="fas fa-truck text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="text-sm font-medium text-gray-900">Delivery Process Started</p>
                                <p class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Admin Marked as Delivered (show only if admin marked it before buyer confirmed) -->
                        @if($order->delivered_at && (!$order->completed_at || $order->delivered_at <= $order->completed_at))
                        <div class="mb-6 relative">
                            <div class="absolute -left-3 mt-1.5 w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <i class="fas fa-check-circle text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="text-sm font-medium text-gray-900">Admin Marked as Delivered</p>
                                <p class="text-xs text-gray-500">{{ $order->delivered_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Order Completed -->
                        @if($order->status == 'completed')
                        <div class="mb-6 relative">
                            <div class="absolute -left-3 mt-1.5 w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <i class="fas fa-check-double text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="text-sm font-medium text-gray-900">Order Received</p>
                                <p class="text-xs text-gray-500">
                                    @if($order->completed_at)
                                        {{ $order->completed_at->format('M d, Y h:i A') }}
                                    @else
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($order->status == 'delivery_started' || ($order->status == 'delivered' && !$order->completed_at))
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('buyer.orders.receive', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                            <i class="fas fa-hand-holding-usd mr-2"></i> Received Order
                        </button>
                        <p class="text-sm text-gray-500 mt-2">
                            Confirm you've received the order and made payment
                        </p>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection