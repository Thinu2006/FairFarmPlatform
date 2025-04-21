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
                <!-- Order Status -->
                <div class="flex items-center mb-8">
                    <div class="bg-gray-100 rounded-full p-4">
                        <i class="fas fa-truck text-2xl text-green-700"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Order Status</h3>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $order->status === 'processing' ? 'bg-green-100 text-green-800' : 
                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                'bg-yellow-100 text-yellow-800') }}">
                            {{ $order->status === 'processing' ? 'Accepted' : ($order->status === 'cancelled' ? 'Declined' : ucfirst($order->status)) }}
                        </span>
                    </div>
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
                                <th class="py-2 text-gray-600">Address:</th>
                                <td class="py-2">{{ $order->farmer->Address }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-gray-600">Quantity:</th>
                                <td class="py-2">{{ number_format($order->quantity, 0) }} Kg</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-gray-600">Payment Method:</th>
                                <td class="py-2">Cash on Delivery</td>
                            </tr>
                            
                        </table>
                    </div>

                    <!-- Price Details (New Column) -->
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
                        
                        <!-- Order Accepted (show only for processing/completed orders) -->
                        @if($order->status == 'processing' || $order->status == 'completed')
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
                        
                        <!-- Order Cancelled (show only for cancelled orders) -->
                        @if($order->status == 'cancelled')
                        <div class="mb-6 relative">
                            <div class="absolute -left-3 mt-1.5 w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center">
                                <i class="fas fa-times text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="text-sm font-medium text-gray-900">Order Declined by Farmer</p>
                                <p class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Order Completed (show only for completed orders) -->
                        @if($order->status == 'completed')
                        <div class="mb-6 relative">
                            <div class="absolute -left-3 mt-1.5 w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="text-sm font-medium text-gray-900">Order Completed</p>
                                <p class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection