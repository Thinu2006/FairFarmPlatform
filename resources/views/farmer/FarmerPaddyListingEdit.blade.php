@extends('layouts.farmer')

@section('title', 'Edit Paddy Listing')

@section('content')
<!-- Main Content -->
<main class="flex-1 py-6 px-20">
    <div class=" mx-auto py-10 px-10 bg-white bg-opacity-95 border border-gray-200 shadow-2xl rounded-2xl">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Edit Paddy Listing</h1>
            <p class="text-lg text-gray-600">Update the details of your paddy listing.</p>
        </div>

        <!-- Form Section -->
        <form action="{{ route('farmer.paddy.listing.update', $paddyListing->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Hidden PaddyID Field -->
            <input type="hidden" name="PaddyID" value="{{ $paddyListing->PaddyID }}">

            <!-- Paddy Type Label -->
            <div class="bg-green-50 p-6 rounded-xl shadow-sm">
                <label class="block text-lg font-bold text-green-900 mb-2">Paddy Type:</label>
                <p class="text-xl font-semibold text-green-900">{{ $paddyListing->paddyType->PaddyName }}</p>
            </div>

            <!-- Price Slider -->
            <div class="bg-green-50 p-6 rounded-xl shadow-sm">
                <label class="block text-lg font-bold text-green-900 mb-4">Price Per 1Kg (Rs.):</label>
                <div class="space-y-6">
                    <!-- Max Price -->
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-bold text-green-900">Max Price:</p>
                        <p class="text-lg font-bold text-green-900">Rs.<span id="maxPriceDisplay">{{ $paddyListing->paddyType->MaxPricePerKg }}</span></p>
                    </div>
                    <!-- Slider -->
                    <input type="range" name="PriceSelected" id="PriceSelected" min="0" max="{{ $paddyListing->paddyType->MaxPricePerKg }}" value="{{ $paddyListing->PriceSelected }}" class="w-full h-2 bg-green-200 rounded-lg appearance-none cursor-pointer transition-all hover:bg-green-300" oninput="updatePriceDisplay()">
                    <!-- Selected Price -->
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-bold text-green-900">Selected Price:</p>
                        <p class="text-lg font-bold text-green-900">Rs.<span id="dynamicPriceDisplay">{{ $paddyListing->PriceSelected }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Quantity Input -->
            <div class="bg-green-50 p-6 rounded-xl shadow-sm">
                <label for="Quantity" class="block text-lg font-bold text-green-900 mb-4">Quantity (kg):</label>
                <input type="number" name="Quantity" id="Quantity" value="{{ $paddyListing->Quantity }}" min="1" class="w-full p-3 border-2 border-green-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-300 transition-all hover:border-green-400" required>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-10">
                <button type="button" onclick="window.location.href='{{ route('farmer.paddy.listing') }}'" class="px-8 py-3 bg-gray-500 text-white rounded-xl shadow-md hover:bg-gray-600 transition-all transform hover:scale-105">
                    Back
                </button>
                <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl shadow-md hover:bg-green-700 transition-all transform hover:scale-105">
                    Update
                </button>
            </div>
        </form>
    </div>
</main>

<!-- JavaScript for Dynamic Updates -->
<script>
    // Function to update the price display
    function updatePriceDisplay() {
        const priceSlider = document.getElementById('PriceSelected');
        const dynamicPriceDisplay = document.getElementById('dynamicPriceDisplay');
        dynamicPriceDisplay.textContent = priceSlider.value;
    }

    // Initialize price display on page load
    document.addEventListener('DOMContentLoaded', function () {
        updatePriceDisplay(); // Set initial selected price
    });
</script>
@endsection