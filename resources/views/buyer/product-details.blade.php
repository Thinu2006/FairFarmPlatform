@extends('layouts.app')

@section('content')
    <section class="py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-6xl mx-auto">
            <!-- Improved breadcrumb with back button -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 sm:mb-8">
                <a href="{{ route('buyer.products') }}" class="flex items-center text-[#1F4529] hover:text-green-800 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Products
                </a>
                <div class="text-sm text-gray-500">
                    <span class="text-[#1F4529]">Products</span> / {{ $paddyListing->paddyType->PaddyName }}
                </div>
            </div>

            <!-- Main Product Card -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Product Image Section -->
                    <div class="lg:w-2/5 relative">
                        <div class="aspect-w-4 aspect-h-3 lg:aspect-none">
                            <img src="{{ asset('storage/' . $paddyListing->paddyType->Image) }}" 
                                 alt="{{ $paddyListing->paddyType->PaddyName }}" 
                                 class="w-full h-64 sm:h-80 md:h-96 lg:h-full object-cover">
                        </div>
                        <!-- Availability badge -->
                        <div class="absolute top-4 sm:top-6 left-4 sm:left-6 bg-white/90 backdrop-blur-sm px-3 sm:px-4 py-1 sm:py-2 rounded-full shadow-md">
                            <span class="text-xs sm:text-sm font-semibold text-[#1F4529]">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $paddyListing->Quantity }} kg available
                            </span>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="p-4 sm:p-6 lg:p-8 lg:w-3/5">
                        <!-- Product Header -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 sm:mb-6">
                            <div class="mb-3 sm:mb-0">
                                <h1 class="text-2xl font-bold text-gray-900 mb-1">
                                    {{ $paddyListing->paddyType->PaddyName }}
                                </h1>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-[#1F4529]">
                                    Rs {{ number_format($paddyListing->PriceSelected, 2) }}
                                </span>
                                <span class="text-gray-500 text-xs sm:text-sm">/ kg</span>
                            </div>
                        </div>

                        <!-- Farmer Card -->
                        <div class="bg-[#F8FAF7] border border-[#E8F0E5] rounded-lg sm:rounded-xl p-4 sm:p-5 mb-2">
                            <div class="flex items-start">
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 ">
                                        {{ $paddyListing->farmer->FullName }}
                                    </h3>
                                    <p class="text-sm sm:text-base text-gray-600 flex items-center">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $paddyListing->farmer->Address }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Form Section -->
                        <form action="{{ route('buyer.place.order') }}" method="POST" id="orderForm">
                            @csrf
                            <input type="hidden" name="listing_id" value="{{ $paddyListing->id }}">
                            
                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Quantity Selector -->
                            <div class="mb-4 sm:mb-6">
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2 sm:mb-3">
                                    Select Quantity (in kilograms)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="quantity" 
                                           name="quantity" 
                                           min="1" 
                                           max="{{ $paddyListing->Quantity }}"
                                           value="{{ old('quantity', 1) }}"
                                           class="block w-full px-4 sm:px-5 py-2 sm:py-3 text-base sm:text-lg border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-[#1F4529] focus:border-[#1F4529] @error('quantity') border-red-500 @enderror"
                                           required
                                           step="0.1">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 sm:pr-5 pointer-events-none">
                                        <span class="text-gray-500 text-sm sm:text-base">kg</span>
                                    </div>
                                </div>
                                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-500">
                                    Maximum available: <span class="font-medium">{{ $paddyListing->Quantity }} kg</span>
                                </p>
                                @error('quantity')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p id="quantity-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid quantity between 1 and {{ $paddyListing->Quantity }} kg</p>
                            </div>
                            
                            <!-- Order Summary -->
                            <div class="bg-[#F8FAF7] border border-[#E8F0E5] rounded-lg sm:rounded-xl p-4 sm:p-5 mb-6 sm:mb-8">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Order Summary</h3>
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm sm:text-base text-gray-600">Price per kg</span>
                                        <span class="text-sm sm:text-base font-medium">Rs {{ number_format($paddyListing->PriceSelected, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm sm:text-base text-gray-600">Quantity</span>
                                        <span class="text-sm sm:text-base font-medium"><span id="quantity-preview">{{ old('quantity', 1) }}</span> kg</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm sm:text-base text-gray-600">Delivery fee (5%)</span>
                                        <span class="text-sm sm:text-base font-medium">Rs <span id="shipping-preview">{{ number_format($paddyListing->PriceSelected * 0.05, 2) }}</span></span>
                                    </div>
                                    <div class="border-t border-gray-200 my-1 sm:my-2"></div>
                                    <div class="flex justify-between text-base sm:text-lg font-bold text-[#1F4529]">
                                        <span>Total Amount</span>
                                        <span>Rs <span id="total-preview">{{ number_format($paddyListing->PriceSelected * 1.05, 2) }}</span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Button -->
                            <button type="submit" 
                                    id="submitBtn"
                                    class="w-full flex justify-center items-center py-3 sm:py-3 px-4 sm:px-3 border border-transparent rounded-lg sm:rounded-xl shadow-sm text-base sm:text-lg font-bold text-white bg-[#1F4529] hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1F4529] transition duration-150 ease-in-out transform hover:scale-[1.01]">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for dynamic price calculation and validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const quantityPreview = document.getElementById('quantity-preview');
            const shippingPreview = document.getElementById('shipping-preview');
            const totalPreview = document.getElementById('total-preview');
            const quantityError = document.getElementById('quantity-error');
            const orderForm = document.getElementById('orderForm');
            const submitBtn = document.getElementById('submitBtn');
            const pricePerKg = {{ $paddyListing->PriceSelected }};
            const maxQuantity = {{ $paddyListing->Quantity }};

            // Real-time validation for quantity input
            quantityInput.addEventListener('input', function() {
                const quantity = parseFloat(this.value) || 0;
                
                // Validate quantity
                if (quantity <= 0 || quantity > maxQuantity || isNaN(quantity)) {
                    quantityError.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    quantityError.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
                
                // Calculate prices
                const subtotal = pricePerKg * quantity;
                const shippingFee = subtotal * 0.05;
                const grandTotal = subtotal + shippingFee;
                
                quantityPreview.textContent = quantity.toFixed(1);
                shippingPreview.textContent = shippingFee.toFixed(2);
                totalPreview.textContent = grandTotal.toFixed(2);
            });

            // Form submission validation
            orderForm.addEventListener('submit', function(e) {
                const quantity = parseFloat(quantityInput.value) || 0;
                const termsChecked = document.getElementById('terms').checked;
                
                if (quantity <= 0 || quantity > maxQuantity || isNaN(quantity)) {
                    e.preventDefault();
                    quantityError.classList.remove('hidden');
                    quantityInput.focus();
                }
                
                if (!termsChecked) {
                    e.preventDefault();
                    alert('Please agree to the terms and conditions');
                    document.getElementById('terms').focus();
                }
            });

            // Initialize with correct values if there's old input
            @if(old('quantity'))
                const oldQuantity = parseFloat({{ old('quantity') }});
                if (!isNaN(oldQuantity)) {
                    quantityInput.value = oldQuantity;
                    quantityInput.dispatchEvent(new Event('input'));
                }
            @endif
        });
    </script>

    <!-- BotMan Chatbot Integration -->
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
@endsection