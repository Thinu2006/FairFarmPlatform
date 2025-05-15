@extends('layouts.farmer')

@section('title', 'My Orders')

@section('content')
<section class="py-1 sm:py-8 px-0 sm:px-6 bg-gray-50">
    <!-- Success Notification (Fixed position) -->
    @if(session('success'))
    <div id="successNotification" class="fixed top-4 right-4 z-50">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
                <button onclick="hideNotification('successNotification')" class="ml-4 text-green-700 hover:text-green-900">
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
                <span class="font-medium">{!! nl2br(e(session('error'))) !!}</span>
                <button onclick="hideNotification('errorNotification')" class="ml-4 text-red-700 hover:text-red-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Info Notification -->
    @if(session('info'))
    <div id="infoNotification" class="fixed top-4 right-4 z-50">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('info') }}</span>
                <button onclick="hideNotification('infoNotification')" class="ml-4 text-blue-700 hover:text-blue-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="max-w-7xl mx-auto">
        <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between justify-center">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-merriweather">My Orders</h1>
                    </div>
                </div>
            </div>
        </header>  

        <!-- Search Section -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6 mb-4 p-4 sm:p-6 text-sm">
            <form action="{{ route('farmer.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-grow">
                    <input type="text" name="search" placeholder="Search by buyer name or paddy type" 
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-green-700"
                        value="{{ request('search') }}">
                </div>
                <div class="min-w-[150px]">
                    <select name="status" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-green-700">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Accepted</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-green-800 text-white rounded-md hover:bg-green-800 whitespace-nowrap">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('farmer.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 whitespace-nowrap">
                        <i class="fas fa-times mr-1"></i> Clear
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Rest of your content remains the same -->
        @if ($orders->isEmpty())
            <div class="text-center bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-600 text-lg">No orders found.</p>
            </div>
        @else
            <!-- Desktop Table View (hidden on small screens) -->
            <div class="hidden sm:block bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Buyer
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paddy Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->buyer->FullName }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->paddyType->PaddyName }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($order->quantity, 0) }} bu
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Rs. {{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->status == 'cancelled')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Declined
                                            </span>
                                        @elseif($order->status == 'processing')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Accepted
                                            </span>
                                        @elseif($order->status == 'completed')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        @elseif($order->status == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                            @if(isset($order->has_sufficient_quantity) && !$order->has_sufficient_quantity)
                                                <span class="block mt-1 text-xs text-red-600">
                                                    Insufficient quantity<br>
                                                    Need: {{ number_format($order->quantity) }}bu<br>
                                                    Available: {{ number_format($order->available_quantity) }}bu
                                                </span>
                                            @endif
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->status == 'pending')
                                            <div class="flex space-x-2">
                                                @if(!isset($order->has_sufficient_quantity) || $order->has_sufficient_quantity)
                                                    <form action="{{ route('farmer.orders.update-status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="processing">
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded text-sm">
                                                            Accept
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form action="{{ route('farmer.orders.update-status', $order->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded text-sm">
                                                        Decline
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Mobile Card View (visible only on small screens) -->
            <div class="sm:hidden space-y-4">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="text-sm text-gray-500">Order #{{ $order->id }}</span>
                                <h3 class="font-medium">{{ $order->paddyType->PaddyName }}</h3>
                            </div>
                            
                            <div>
                                @if($order->status == 'cancelled')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Declined
                                    </span>
                                @elseif($order->status == 'processing')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Accepted
                                    </span>
                                @elseif($order->status == 'completed')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @elseif($order->status == 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-b border-gray-100 py-2 mb-3">
                            <div class="grid grid-cols-2 gap-1 text-sm">
                                <div class="text-gray-500">Buyer:</div>
                                <div>{{ $order->buyer->FullName }}</div>
                                
                                <div class="text-gray-500">Quantity:</div>
                                <div>{{ number_format($order->quantity, 0) }} bu</div>
                                
                                <div class="text-gray-500">Total Amount:</div>
                                <div>Rs. {{ number_format($order->total_amount, 2) }}</div>
                                
                                <div class="text-gray-500">Date:</div>
                                <div>{{ $order->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        @if(isset($order->has_sufficient_quantity) && !$order->has_sufficient_quantity && $order->status == 'pending')
                            <div class="mb-3 p-2 bg-red-50 text-red-600 text-xs rounded">
                                <p>Insufficient quantity</p>
                                <p>Need: {{ number_format($order->quantity) }}bu</p>
                                <p>Available: {{ number_format($order->available_quantity) }}bu</p>
                            </div>
                        @endif

                        @if($order->status == 'pending')
                            <div class="flex justify-end space-x-2">
                                @if(!isset($order->has_sufficient_quantity) || $order->has_sufficient_quantity)
                                    <form action="{{ route('farmer.orders.update-status', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm">
                                            Accept
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('farmer.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">
                                        Decline
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<script>
    // Notification functions
    function hideNotification(id) {
        const notification = document.getElementById(id);
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
        setTimeout(() => hideNotification('successNotification'), 5000);
    }

    const errorNotification = document.getElementById('errorNotification');
    if (errorNotification) {
        setTimeout(() => hideNotification('errorNotification'), 5000);
    }

    const infoNotification = document.getElementById('infoNotification');
    if (infoNotification) {
        setTimeout(() => hideNotification('infoNotification'), 5000);
    }
</script>

<!-- Animate.css for notification animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection