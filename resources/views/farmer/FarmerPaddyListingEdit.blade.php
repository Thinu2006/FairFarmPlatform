@extends('layouts.farmer')

@section('title', 'Edit Paddy Listing')

@section('content')
<!-- Main Content -->
<main class="flex-1 p-4 sm:p-6 lg:p-8 font-sans">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-700 to-green-600 px-6 py-8 text-center">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2 font-merriweather">Edit Paddy Listing</h1>
            <p class="text-green-100 text-sm sm:text-base lg:text-lg font-open-sans">Update the details of your paddy listing</p>
        </div>

        <!-- Form Section -->
        <form action="{{ route('farmer.paddy.listing.update', $paddyListing->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Hidden PaddyID Field -->
            <input type="hidden" name="PaddyID" value="{{ $paddyListing->PaddyID }}">

            <!-- Paddy Type Label -->
            <div class="bg-green-50 p-4 sm:p-6 rounded-lg shadow-sm border border-green-100">
                <div class="flex items-center space-x-2">
                    <span class="text-sm sm:text-base lg:text-lg font-semibold text-green-800 font-open-sans">Paddy Type:</span>
                    <span class="text-base sm:text-lg lg:text-xl font-bold text-green-900 font-merriweather">{{ $paddyListing->paddyType->PaddyName }}</span>
                </div>
            </div>

            <!-- Price Slider -->
            <div class="bg-green-50 p-4 sm:p-6 rounded-lg shadow-sm border border-green-100">
                <label class="block text-sm sm:text-base lg:text-lg font-semibold text-green-800 mb-4 font-open-sans">Price Per 1Kg (Rs.):</label>
                <div class="space-y-4 sm:space-y-6">
                    <!-- Max Price -->
                    <div class="flex items-center justify-between">
                        <p class="text-sm sm:text-base lg:text-lg font-semibold text-green-800 font-open-sans">Max Price:</p>
                        <p class="text-sm sm:text-base lg:text-lg font-bold text-green-900 font-merriweather">Rs. <span id="maxPriceDisplay">{{ $paddyListing->paddyType->MaxPricePerKg }}</span></p>
                    </div>
                    <!-- Slider -->
                    <input type="range" name="PriceSelected" id="PriceSelected" min="0" max="{{ $paddyListing->paddyType->MaxPricePerKg }}" value="{{ $paddyListing->PriceSelected }}" 
                           class="w-full h-2 sm:h-2.5 bg-green-200 rounded-lg appearance-none cursor-pointer accent-green-600 transition-all hover:accent-green-700">
                    <!-- Selected Price -->
                    <div class="flex items-center justify-between">
                        <p class="text-sm sm:text-base lg:text-lg font-semibold text-green-800 font-open-sans">Selected Price:</p>
                        <p class="text-sm sm:text-base lg:text-lg font-bold text-green-900 font-merriweather">Rs. <span id="dynamicPriceDisplay">{{ $paddyListing->PriceSelected }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Quantity Input -->
            <div class="bg-green-50 p-4 sm:p-6 rounded-lg shadow-sm border border-green-100">
                <label for="Quantity" class="block text-sm sm:text-base lg:text-lg font-semibold text-green-800 mb-4 font-open-sans">Quantity (kg):</label>
                <input type="number" name="Quantity" id="Quantity" value="{{ $paddyListing->Quantity }}" min="1" 
                       class="w-full px-4 py-2 sm:px-5 sm:py-3 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all text-sm sm:text-base text-gray-700 font-open-sans">
            </div>

            <!-- Buttons -->
            <div class="flex flex-row justify-between gap-4 pt-6">
                <button type="button" onclick="window.location.href='{{ route('farmer.paddy.listing') }}'" 
                        class="px-6 py-2 sm:px-8 sm:py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-semibold shadow-sm text-sm sm:text-base border border-gray-200 font-open-sans">
                    Back
                </button>
                <button type="submit" 
                        class="px-6 py-2 sm:px-8 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all font-semibold shadow-sm text-sm sm:text-base font-open-sans">
                    Update 
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    // Function to update the price display
    function updatePriceDisplay() {
        const priceSlider = document.getElementById('PriceSelected');
        const dynamicPriceDisplay = document.getElementById('dynamicPriceDisplay');
        dynamicPriceDisplay.textContent = priceSlider.value;
    }

    // Initialize price display on page load
    document.addEventListener('DOMContentLoaded', function () {
        updatePriceDisplay();
        
        // Update price display when slider moves
        document.getElementById('PriceSelected').addEventListener('input', updatePriceDisplay);
    });
</script>
@endsection