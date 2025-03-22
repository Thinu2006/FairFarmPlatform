@extends('layouts.farmer')

@section('title', 'List New Paddy Type')

@section('content')
<!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto">
    <div class="max-w-4xl mx-auto p-8 bg-white shadow-2xl rounded-2xl">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-green-900 mb-4">List New Paddy Type</h1>
            <p class="text-lg text-gray-600">Fill out the form to list a new paddy type for sale.</p>
        </div>

        <!-- Form Section -->
        <form action="{{ route('farmer.selling.paddy.store') }}" method="POST" id="sellingForm" class="space-y-8">
            @csrf
            <!-- Pass FarmerID as a hidden input -->
            <input type="hidden" name="FarmerID" value="{{ auth()->id() }}">
            
            <!-- Paddy Type Dropdown -->
            <div>
                <label for="PaddyType" class="block text-lg font-semibold text-green-900 mb-3">Select Paddy Type:</label>
                <select name="PaddyID" id="PaddyType" class="w-full p-3 border-2 border-green-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 transition-all">
                    <option value="" disabled selected>Select a Paddy Type</option>
                    @foreach($paddyTypes as $type)
                        <option value="{{ $type->PaddyID }}" data-max-price="{{ $type->MaxPricePerKg }}" data-image="{{ $type->Image }}" data-name="{{ $type->PaddyName }}">{{ $type->PaddyName }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Price Slider -->
            <div id="paddyDetails">
                <label class="block text-lg font-semibold text-green-900 mb-3">Price Per 1Kg (Rs.):</label>
                <div class="flex items-center space-x-4">
                    <input type="range" name="PriceSelected" id="PriceSelected" min="0" max="0" value="0" class="w-full cursor-pointer transition-all">
                    <span id="selectedPrice" class="px-4 py-2 bg-green-100 text-green-900 rounded-xl shadow-sm">Select a Paddy Type</span>
                </div>
                <img id="paddyImage" src="" alt="Paddy Image" class="w-48 h-48 object-cover rounded-xl mt-6 mx-auto" style="display:none;">
            </div>

            <!-- Quantity Input -->
            <div>
                <label for="Quantity" class="block text-lg font-semibold text-green-900 mb-3">Quantity (kg):</label>
                <input type="number" name="Quantity" id="Quantity" min="1" class="w-full p-3 border-2 border-green-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 transition-all" required>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center mt-10">
                <button type="button" onclick="window.history.back()" class="px-6 py-3 bg-gray-400 text-white rounded-xl shadow-md hover:bg-gray-500 transition-all transform hover:scale-105">
                    Back
                </button>
                <button type="submit" class="px-6 py-3 bg-green-700 text-white rounded-xl shadow-md hover:bg-green-800 transition-all transform hover:scale-105">
                    Submit
                </button>
            </div>
        </form>
    </div>
</main>

<!-- JavaScript for Dynamic Updates -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paddyTypeDropdown = document.getElementById('PaddyType');
        const priceSlider = document.getElementById('PriceSelected');
        const selectedPriceDisplay = document.getElementById('selectedPrice');
        const paddyImage = document.getElementById('paddyImage');

        paddyTypeDropdown.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const maxPrice = selectedOption.getAttribute('data-max-price');
            const imagePath = selectedOption.getAttribute('data-image');
            const paddyName = selectedOption.getAttribute('data-name');

            // Update the image
            if (imagePath) {
                paddyImage.src = "{{ asset('storage/') }}/" + imagePath;
                paddyImage.style.display = 'block'; // Show the image
            } else {
                paddyImage.style.display = 'none'; // Hide the image if no image path
            }

            // Update the slider max value
            priceSlider.max = maxPrice;
            priceSlider.value = maxPrice; // Set the slider to the max price initially

            // Update the selected price display
            selectedPriceDisplay.textContent = maxPrice;
        });

        // Update the price display when the slider is moved
        priceSlider.addEventListener('input', function() {
            selectedPriceDisplay.textContent = this.value;
        });
    });
</script>
@endsection