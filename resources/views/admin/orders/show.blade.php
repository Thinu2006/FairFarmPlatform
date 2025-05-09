@extends('layouts.admin')

@section('content')
<div class="py-1 sm:py-8 px-0 sm:px-6 bg-gray-50">
    <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:justify-between ">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-merriweather">Order Details #{{ $order->id }}</h1>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Flash message -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Order details card -->
    <div class="mt-6 bg-white rounded-md shadow-md overflow-hidden">
        <div class="p-6">
            <div class="text-right">
                <!-- Order Status Badge -->
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
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-[16px]">
                <div>
                    <h5 class="text-lg font-medium mb-3">Buyer Information</h5>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="mb-2"><span class="font-bold">Name:</span> {{ $order->buyer->FullName }}</p>
                        <p class="mb-2"><span class="font-bold">Email:</span> {{ $order->buyer->Email }}</p>
                        <p class="mb-2"><span class="font-bold">Contact No:</span> {{ $order->buyer->ContactNo }}</p>
                        <p class="mb-2"><span class="font-bold">Delivery Address:</span> {{ $order->buyer->Address }}</p>
                    </div>
                </div>
                
                <div>
                    <h5 class="text-lg font-medium text-gray-700 mb-3">Farmer Information</h5>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="mb-2"><span class="font-bold">Name:</span> {{ $order->farmer->FullName }}</p>
                        <p class="mb-2"><span class="font-bold">Email:</span> {{ $order->farmer->Email }}</p>
                        <p class="mb-2"><span class="font-bold">Contact No:</span> {{ $order->farmer->ContactNo }}</p>
                        <p class="mb-2"><span class="font-bold">Address:</span> {{ $order->farmer->Address }}</p>   
                    </div>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-[16px]">
                <div>
                    <h5 class="text-lg font-medium text-gray-700 mb-3">Order Details</h5>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <div>
                            <p class="mb-2"><span class="font-bold">Paddy Type:</span> {{ $order->paddyType->PaddyName }}</p>
                            <p class="mb-2"><span class="font-bold">Quantity:</span> {{ number_format($order->quantity, 0) }} kg</p>
                            <p class="mb-2"><span class="font-bold">Price Per Kg:</span> Rs. {{ number_format($order->price_per_kg, 2) }}</p>
                            <p class="mb-2"><span class="font-bold">Created:</span> {{ $order->created_at->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h5 class="text-lg font-medium text-gray-700 mb-3">Price Breakdown</h5>
                    <div class="bg-gray-50 p-4 rounded-md text-[16px]">
                        <div class="flex justify-between py-2">
                            <p class="font-bold">Subtotal:</p>
                            <p>Rs. {{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <div class="flex justify-between py-2">
                            <p class="font-bold">Shipping Fee (5%):</p>
                            <p>Rs. {{ number_format($order->total_amount * 0.05, 2) }}</p>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-200 mt-2 pt-2">
                            <p class="font-bold">Grand Total:</p>
                            <p class="font-bold">Rs. {{ number_format($order->total_amount * 1.05, 2) }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">* 5% shipping fee is charged to the buyer</p>
                    </div>
                </div>
            </div>

            <!-- Delivery action buttons -->
            <div class="mt-6 p-6 border-t border-gray-200">
                @if($order->status == 'processing')
                    <form action="{{ route('admin.orders.start-delivery', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-truck mr-2"></i> Start Delivery Process
                        </button>
                    </form>
                @elseif($order->status == 'delivery_started')
                    <form action="{{ route('admin.orders.complete-delivery', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                            <i class="fas fa-check-circle mr-2"></i> Mark as Successfully Delivered
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection