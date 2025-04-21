@extends('layouts.farmer')

@section('content')
<section class="py-1 sm:py-8 px-0 sm:px-6 bg-gray-50">
    <div class="max-w-7xl mx-auto ">
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

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{!! nl2br(e(session('error'))) !!}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                <p>{{ session('info') }}</p>
            </div>
        @endif

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
                                        {{ number_format($order->quantity, 0) }} kg
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
                                                    Need: {{ number_format($order->quantity) }}kg<br>
                                                    Available: {{ number_format($order->available_quantity) }}kg
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
                                <div>{{ number_format($order->quantity, 0) }} kg</div>
                                
                                <div class="text-gray-500">Total Amount:</div>
                                <div>Rs. {{ number_format($order->total_amount, 2) }}</div>
                                
                                <div class="text-gray-500">Date:</div>
                                <div>{{ $order->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        @if(isset($order->has_sufficient_quantity) && !$order->has_sufficient_quantity && $order->status == 'pending')
                            <div class="mb-3 p-2 bg-red-50 text-red-600 text-xs rounded">
                                <p>Insufficient quantity</p>
                                <p>Need: {{ number_format($order->quantity) }}kg</p>
                                <p>Available: {{ number_format($order->available_quantity) }}kg</p>
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
@endsection