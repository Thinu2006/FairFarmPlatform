@extends('layouts.admin')

@section('content')
<div class="rounded-2xl bg-gray-50 md:p-4 p-1">
    <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between justify-center">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">Order Management</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Search and filter -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6 mb-4 p-4 sm:p-6 text-sm">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <div class="flex-grow">
                <input type="text" name="query" placeholder="Search"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-green-700"
                    value="{{ request('query') }}">
            </div>
            <div class="min-w-[150px]">
                <select name="status" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-green-700">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 bg-green-800 text-white rounded-md hover:bg-green-800 whitespace-nowrap">
                    <i class="fas fa-search mr-1"></i> Search
                </button>
                @if(request('query') || request('status'))
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 whitespace-nowrap">
                    Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Flash messages -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 text-sm sm:text-base" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Orders table -->
    <div class="overflow-hidden bg-white rounded-md shadow">
        <!-- Desktop Table -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Buyer
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Farmer
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Paddy Type
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Amount
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->id }}
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">
                            {{ $order->buyer->FullName }}
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">
                            {{ $order->farmer->FullName }}
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">
                            {{ $order->paddyType->PaddyName }}
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->quantity }} kg
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rs. {{ number_format($order->total_amount * 1.05, 2) }}
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($order->status == 'processing') bg-green-100 text-green-800
                                @elseif($order->status == 'completed') bg-green-100 text-green-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $order->status == 'cancelled' ? 'Declined' : ($order->status == 'processing' ? 'Accepted' : ucfirst($order->status)) }}
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 sm:px-6 py-4 text-sm text-gray-500 text-center">
                            No orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards - Single Column -->
        <div class="sm:hidden space-y-3">
            @forelse ($orders as $order)
            <div class="bg-white rounded-lg shadow p-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Order #{{ $order->id }}</span>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($order->status == 'processing') bg-green-100 text-green-800
                            @elseif($order->status == 'completed') bg-green-100 text-green-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $order->status == 'cancelled' ? 'Declined' : ($order->status == 'processing' ? 'Accepted' : ucfirst($order->status)) }}
                        </span>
                    </div>

                    <div class="border-t border-gray-100 pt-2">
                        <p class="text-sm font-medium text-gray-900">{{ $order->paddyType->PaddyName }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="space-y-1 text-sm">
                        <div>
                            <span class="text-gray-500">Buyer: </span>
                            <span class="text-gray-900">{{ $order->buyer->FullName }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Farmer: </span>
                            <span class="text-gray-900">{{ $order->farmer->FullName }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Quantity: </span>
                            <span class="text-gray-900">{{ $order->quantity }} kg</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Total: </span>
                            <span class="text-gray-900">Rs. {{ number_format($order->total_amount * 1.05, 2) }}</span>
                        </div>
                    </div>

                    <div class="pt-2 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            <i class="fas fa-eye mr-1"></i>View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-base font-medium text-gray-900 mt-2">No orders found</h3>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
    <div class="mt-4 sm:mt-6">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
