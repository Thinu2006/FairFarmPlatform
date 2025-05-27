@extends('layouts.app')

@section('content')

<div class="py-12 bg-gray-50">
    <!-- Success Notification -->
    @if(session('success'))
    <div id="successNotification" class="fixed top-4 right-4 z-50">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
                <button onclick="hideNotification()" class="ml-4 text-green-700 hover:text-green-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Error Notification -->
    @if(session('error'))
    <div id="errorNotification" class="fixed top-4 right-4 z-50">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
                <button onclick="hideErrorNotification()" class="ml-4 text-red-700 hover:text-red-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif


<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('buyer.orders') }}" class="text-green-700 hover:text-green-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to Orders
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Order Details</h1>

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
                    @elseif($order->status == 'buyer_cancelled')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Cancelled by You
                        </span>
                    @elseif($order->status == 'farmer_cancelled')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Declined by Farmer
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
                                <td class="py-2">{{ number_format($order->quantity, 0) }} kg</td>
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
                                <span class="text-gray-600">Price Per kg:</span>
                                <span class="font-medium">Rs {{ number_format($order->price_per_kg, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">{{ number_format($order->quantity, 0) }} kg</span>
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

               <!-- Horizontal Order Timeline Section -->
<div class="mt-12 border-t pt-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-8">Order Status Timeline</h3>

    <div class="relative">
        <!-- Timeline line -->
        <div class="absolute left-0 right-0 top-4 h-1 bg-gray-200"></div>

        <div class="flex items-center justify-between relative">
            <!-- Order Placed -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-900">Order Placed</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Order Accepted -->
            @if(in_array($order->status, ['processing', 'delivery_started', 'delivered', 'completed']))
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-900">Accepted</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $order->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
            @else
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shadow-sm">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-400">Accepted</p>
                </div>
            </div>
            @endif

            <!-- Delivery Started -->
            @if(in_array($order->status, ['delivery_started', 'delivered', 'completed']))
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-900">Delivery Started</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $order->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
            @else
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shadow-sm">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-400">Delivery</p>
                </div>
            </div>
            @endif

            <!-- Admin Marked as Delivered -->
            @if($order->delivered_at && (!$order->completed_at || $order->delivered_at <= $order->completed_at))
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-900">Delivered</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $order->delivered_at->format('M d, Y') }}</p>
                </div>
            </div>
            @else
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shadow-sm">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-400">Delivered</p>
                </div>
            </div>
            @endif

            <!-- Order Completed -->
            @if($order->status == 'completed')
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-900">Completed</p>
                    <p class="text-xs text-gray-500 mt-1">
                        @if($order->completed_at)
                            {{ $order->completed_at->format('M d, Y') }}
                        @else
                            {{ $order->updated_at->format('M d, Y') }}
                        @endif
                    </p>
                </div>
            </div>
            @else
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shadow-sm">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="text-center mt-3">
                    <p class="text-sm font-medium text-gray-400">Completed</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Progress bar -->
   
</div>
                <!-- Action Buttons -->
                @if($order->status == 'delivery_started' || ($order->status == 'delivered' && !$order->completed_at))
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('buyer.orders.receive', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-900 transition duration-200">
                            <i class="fas fa-hand-holding-usd mr-2"></i> Received Order
                        </button>
                        <p class="text-sm text-gray-500 mt-2">
                            Confirm you've received the order and made payment
                        </p>
                    </form>
                </div>
                @endif

                @if($order->status == 'pending')
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                            <i class="fas fa-times-circle mr-2"></i> Cancel Order
                        </button>
                        <p class="text-sm text-gray-500 mt-2">
                            You can cancel this order until the farmer accepts it.
                        </p>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
