@extends('layouts.admin')

@section('content')
<div class="py-1 sm:py-8 px-0 sm:px-6 bg-gray-50">
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

    <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center mb-4">
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

    <!-- Order details card -->
    <div class="mt-6 pb-2 bg-white rounded-md shadow-md overflow-hidden">
        <div class="p-6">
            <div class="text-right">
                <!-- Order Status Badge -->
                @if($order->status == 'pending')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full" style="background-color: rgba(255, 193, 7, 0.2); color: rgba(255, 193, 7, 1); border: 1px solid rgba(255, 193, 7, 1);">
                        Pending
                    </span>
                @elseif($order->status == 'processing')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full" style="background-color: rgba(31, 69, 41, 0.2); color: rgba(31, 69, 41, 1); border: 1px solid rgba(31, 69, 41, 1);">
                        Accepted
                    </span>
                @elseif($order->status == 'delivery_started')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full" style="background-color: rgba(76, 175, 80, 0.2); color: rgba(76, 175, 80, 1); border: 1px solid rgba(76, 175, 80, 1);">
                        Delivery Started
                    </span>
                @elseif($order->status == 'delivered' || $order->status == 'completed')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full" style="background-color: rgba(139, 195, 74, 0.2); color: rgba(139, 195, 74, 1); border: 1px solid rgba(139, 195, 74, 1);">
                        @if($order->status == 'delivered') Delivered @else Completed @endif
                    </span>
                @elseif($order->status == 'cancelled')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full" style="background-color: rgba(244, 67, 54, 0.2); color: rgba(244, 67, 54, 1); border: 1px solid rgba(244, 67, 54, 1);">
                        Declined
                    </span>
                @endif
            </div>

            <!-- Rest of your order details content remains the same -->
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
                            <p class="mb-2"><span class="font-bold">Quantity:</span> {{ number_format($order->quantity, 0) }} bu</p>
                            <p class="mb-2"><span class="font-bold">Price Per kg:</span> Rs. {{ number_format($order->price_per_kg, 2) }}</p>
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
            <div class="mt-6 pt-6 border-t border-gray-200">
                @if($order->status == 'processing')
                    <form action="{{ route('admin.orders.start-delivery', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-md transition duration-200 font-medium border border-blue-800">
                            <i class="fas fa-truck mr-2"></i> Start Delivery Process
                        </button>
                    </form>
                @elseif($order->status == 'delivery_started')
                    <form action="{{ route('admin.orders.complete-delivery', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-900 text-white rounded-md transition duration-200 font-medium border">
                            <i class="fas fa-check-circle mr-2"></i> Mark as Successfully Delivered
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Notification functions
    function hideNotification() {
        const notification = document.getElementById('successNotification');
        if (notification) {
            notification.classList.add('animate__animated', 'animate__fadeOutRight');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    function hideErrorNotification() {
        const notification = document.getElementById('errorNotification');
        if (notification) {
            notification.classList.add('animate__animated', 'animate__fadeOutRight');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    // Auto-hide notifications after 5 seconds
    const successNotification = document.getElementById('successNotification');
    if (successNotification) {
        setTimeout(hideNotification, 5000);
    }

    const errorNotification = document.getElementById('errorNotification');
    if (errorNotification) {
        setTimeout(hideErrorNotification, 5000);
    }
</script>

<!-- Animate.css for notification animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
