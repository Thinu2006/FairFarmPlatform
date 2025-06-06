@extends('layouts.app')

@section('content')
    <section class="relative w-full h-64 bg-cover bg-center flex items-center justify-center" style="background-image: url('./../../Images/BuyerLoginBG.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center px-6 text-center">
            <h2 class="text-white text-3xl md:text-4xl font-bold">All Paddy Products</h2>
            <form action="{{ route('buyer.products') }}" method="GET" class="mt-6 flex text-lg items-center justify-center">
                <input type="text" name="query" placeholder="Search Paddy"
                       class="px-4 py-2 rounded-l-md text-gray-900 sm:w-[300px] w-64 focus:outline-none focus:ring-2 focus:ring-[#1F4529]"
                       value="{{ request('query') }}">
                <button type="submit" class="bg-[#1F4529] text-white px-4 py-2 rounded-r-md hover:bg-green-800 transition">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('query'))
                    <a href="{{ route('buyer.products') }}" class="ml-2 sm:ml-4 text-white hover:underline bg-gray-600 px-3 py-2 rounded-md">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </section>

    <section class="py-16 px-6 sm:px-36 bg-gray-50 mb-6 sm:mb-24">
        <div class="max-w-9xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-3xl font-semibold text-[#1F4529]">Our Products</h3>
                <a href="{{ route('buyer.orders') }}" class="bg-[#1F4529] text-white text-lg px-4 py-2 rounded-md hover:bg-green-800 transition">
                    View My Orders
                </a>
            </div>

            @if(request('query'))
                <div class="flex justify-between items-center mt-4">
                    <p class="text-gray-600">Search results for: <span class="font-semibold">"{{ request('query') }}"</span></p>
                    <p class="text-gray-600">{{ $sellingPaddyTypes->count() }} results found</p>
                </div>
            @endif

            @if($sellingPaddyTypes->isEmpty())
                <div class="text-center mt-20">
                    <p class="text-gray-600 text-lg">No paddy products found matching your search.</p>
                    <a href="{{ route('buyer.products') }}" class="mt-4 inline-block bg-[#1F4529] text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                        View All Products
                    </a>
                </div>
            @else
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-24">
                    @foreach ($sellingPaddyTypes as $paddy)
                        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="h-48 overflow-hidden rounded-md">
                                <img src="{{ asset('storage/' . $paddy->paddyType->Image) }}"
                                     alt="{{ $paddy->paddyType->PaddyName }}"
                                     class="w-full h-full object-cover">
                            </div>

                            <div class="mt-4">
                                <h4 class="text-2xl font-bold text-gray-800">{{ $paddy->paddyType->PaddyName }}</h4>
                                <p class="text-gray-800 font-bold mt-2 text-base">Rs {{ number_format($paddy->PriceSelected, 2) }} per kg</p>
                                <p class="text-gray-800 font-bold mt-2 text-base">Available Quantity: {{ $paddy->Quantity }} kg</p>

                                <div class="mt-3 border-t pt-3 text-base">
                                    <p class="text-gray-600 font-bold">Farmer details</p>
                                    <ul class="text-gray-600  mt-1 space-y-1">
                                        <li class="flex items-start">
                                            <span class="mr-1">•</span>
                                            <span>{{ $paddy->farmer->FullName }}</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="mr-1">•</span>
                                            <span>{{ $paddy->farmer->Address }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <a href="{{ route('buyer.product.details', $paddy->id) }}" class="mt-4 w-full bg-[#1F4529] text-white text-lg px-4 py-2 rounded-md hover:bg-green-800 transition duration-300 block text-center">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">
    <style>
        .botmanWidgetBtn {
            background-color: #1F4529 !important;
        }
        .botmanWidgetContainer {
            z-index: 10000;
        }
    </style>
    <script>
        var botmanWidget = {
            aboutText: 'Need help? Start with "Hi"',
            introMessage: "WELCOME TO FAIRFARM !",
            bubbleAvatarUrl: '',
            mainColor: '#1F4529',
            bubbleBackground: '#1F4529',
            desktopHeight: 500,
            desktopWidth: 400,
            chatServer: '/botman',
            title: 'Paddy Assistant',
            widgetHeight: '500px',
            widgetWidth: '350px',
            headerTextColor: 'white',
            headerBackgroundColor: '#1F4529',
            bodyBackgroundColor: 'white',
            bodyTextColor: '#333333'
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>

    <script>
        // Fix for the My Orders link in the header
        document.addEventListener('DOMContentLoaded', function() {
            const myOrdersLinks = document.querySelectorAll('a');

            myOrdersLinks.forEach(link => {
                if (link.textContent.trim() === 'My Orders') {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        window.location.href = '{{ route('buyer.orders') }}';
                    });
                }
            });
        });
    </script>
@endsection
