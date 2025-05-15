@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-12">
    <!-- Success Notification (Fixed position) -->
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

    <div class="max-w-full mx-auto px-4 md:px-20">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-8">My Orders</h1>
        
        @if($orders->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-8 sm:p-16 text-center">
                <p class="text-gray-600 text-base sm:text-lg">You haven't placed any orders yet.</p>
                <a href="{{ route('buyer.products') }}" class="mt-4 inline-block bg-[#1F4529] text-white px-4 py-2 rounded-md hover:bg-green-800 transition text-base sm:text-lg">
                    Browse Products
                </a>
            </div>
        @else
            <div class="shadow overflow-hidden rounded-lg">
                <div class="responsive-table">
                    <table class="min-w-full divide-y">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-base font-bold text-gray-800 uppercase">
                                    Order ID
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-base font-bold text-gray-800 uppercase">
                                    Paddy Type
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-base font-bold text-gray-800 uppercase">
                                    Quantity
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-base font-bold text-gray-800 uppercase">
                                    Total Amount
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-base font-bold text-gray-800 uppercase">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-base font-bold text-gray-800 uppercase">
                                    Date
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-base font-bold text-gray-800 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="flex flex-col sm:table-row border-b sm:border-b-0 border-gray-200 p-4 sm:p-0">
                                <td data-label="Order ID" class="px-4 py-4 whitespace-nowrap text-base text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td data-label="Paddy Type" class="px-4 py-4 whitespace-nowrap text-base text-gray-900">
                                    {{ $order->paddyType->PaddyName }}
                                </td>
                                <td data-label="Quantity" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-base text-gray-500">
                                    {{ $order->quantity }} bu
                                </td>
                                <td data-label="Total Amount" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-base text-gray-500">
                                    Rs {{ number_format($order->total_amount * 1.05, 2) }}
                                </td>
                                <td data-label="Status" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded text-base 
                                        @if($order->status == 'processing') bg-green-100 text-green-800 
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800 
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $order->status == 'cancelled' ? 'Declined' : ($order->status == 'processing' ? 'Accepted' : ucfirst($order->status)) }}
                                    </span>
                                </td>
                                <td data-label="Date" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-base text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td data-label="Actions" class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-base font-medium text-center sm:text-left">
                                    <a href="{{ route('buyer.order.details', $order->id) }}" class="text-green-600 hover:text-green-900 text-base sm:text-base">
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

    // Auto-hide notifications after 5 seconds
    const successNotification = document.getElementById('successNotification');
    if (successNotification) {
        setTimeout(hideNotification, 5000);
    }
</script>

<!-- Animate.css for notification animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">
<style>
    .botmanWidgetBtn {
        background-color: #1F4529 !important;
    }
    .botmanWidgetContainer {
        z-index: 10000;
    }
    /* Match the chat background to your page */
    .botmanWidgetContainer .message {
        background-color: transparent !important;
    }
    .botmanWidgetContainer .message-content {
        background-color: white !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
    }
    .botmanWidgetContainer .message.received .message-content {
        background-color: #F8FAF7 !important;
        border: 1px solid #E8F0E5 !important;
    }
    .botmanWidgetContainer .chat-container {
        background-color: transparent !important;
        background-image: linear-gradient(to bottom, #f9fafb, white) !important;
    }
    .botmanWidgetContainer .header {
        border-bottom: 1px solid #E8F0E5 !important;
    }
</style>
<script>
    var botmanWidget = {
        aboutText: 'Need help? Start with "Hi"',
        introMessage: "WELCOME TO FAIRFARM! HOW CAN I HELP YOU WITH YOUR ORDERS?",
        bubbleAvatarUrl: '',
        mainColor: '#1F4529',
        bubbleBackground: '#1F4529',
        desktopHeight: 500,
        desktopWidth: 400,
        chatServer: '/botman',
        title: 'Order Assistant',
        widgetHeight: '500px',
        widgetWidth: '350px',
        headerTextColor: 'white',
        headerBackgroundColor: '#1F4529',
        bodyBackgroundColor: 'transparent',
        bodyTextColor: '#333333'
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
@endsection