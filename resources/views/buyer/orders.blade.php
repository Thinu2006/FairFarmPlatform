@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-12 ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">My Orders</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 text-sm sm:text-base" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @if($orders->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 sm:p-6 text-center">
                <p class="text-gray-600 text-sm sm:text-base">You haven't placed any orders yet.</p>
                <a href="{{ route('buyer.products') }}" class="mt-4 inline-block bg-[#1F4529] text-white px-4 py-2 rounded-md hover:bg-green-800 transition text-sm sm:text-base">
                    Browse Products
                </a>
            </div>
        @else
            <div class=" shadow overflow-hidden rounded-lg">
                <div class="responsive-table">
                    <table class="min-w-full divide-y ">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                    Order ID
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                    Paddy Type
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                    Quantity
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                    Total Amount
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                    Date
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="flex flex-col sm:table-row border-b sm:border-b-0 border-gray-200 p-4 sm:p-0">
                                <td data-label="Order ID" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td data-label="Paddy Type" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->paddyType->PaddyName }}
                                </td>
                                <td data-label="Quantity" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->quantity }} Kg
                                </td>
                                <td data-label="Total Amount" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rs {{ number_format($order->total_amount * 1.05, 2) }}
                                </td>
                                <td data-label="Status" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded text-xs 
                                        @if($order->status == 'processing') bg-green-100 text-green-800 
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800 
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $order->status == 'cancelled' ? 'Declined' : ($order->status == 'processing' ? 'Accepted' : ucfirst($order->status)) }}
                                    </span>
                                </td>
                                <td data-label="Date" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td data-label="Actions" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium text-center sm:text-left">
                                    <a href="{{ route('buyer.order.details', $order->id) }}" class="text-green-600 hover:text-green-900 text-sm sm:text-base">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Responsive table styles */
    @media (max-width: 767px) {
        .responsive-table {
            width: 100%;
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .responsive-table tbody {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .responsive-table tr {
            display: flex;
            flex-direction: column;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .responsive-table td {
            display: flex;
            padding: 0.5rem 0;
            border: none;
            align-items: flex-start;
        }
        
        .responsive-table td:before {
            content: attr(data-label) ": ";
            font-weight: 600;
            width: 120px;
            flex-shrink: 0;
            color: #4b5563;
            font-size: 0.875rem;
        }
        
        .responsive-table td > div {
            flex-grow: 1;
            word-break: break-word;
        }

        .responsive-table td[data-label="Actions"] {
            justify-content: center;
            padding-top: 0.5rem;
            margin-top: 0.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .responsive-table td[data-label="Actions"]:before {
            display: none;
        }
        .responsive-table thead {
            display: none;
        }
    }

    @media (min-width: 768px) {
        .responsive-table table {
            display: table;
        }
        
        .responsive-table tr {
            display: table-row;
        }
        
        .responsive-table td {
            display: table-cell;
        }
        
        .responsive-table td:before {
            display: none;
        }
    }
</style>
@endsection