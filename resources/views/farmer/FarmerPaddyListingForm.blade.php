@extends('layouts.farmer')

@section('title', 'List New Paddy Type')

@section('content')
<!-- Main Content -->
<main class="flex-1 p-3 sm:p-6 lg:p-8 overflow-y-auto">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg sm:rounded-xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-green-700 px-4 py-6 sm:px-6 sm:py-8 text-center">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-1 sm:mb-2">List New Paddy Type</h1>
            <p class="text-green-100 text-sm sm:text-base">Fill out the form to list a new paddy type for sale</p>
        </div>

        <!-- Form Section -->
        <form action="{{ route('farmer.selling.paddy.store') }}" method="POST" id="sellingForm" class="p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
            @csrf
            <input type="hidden" name="FarmerID" value="{{ auth()->id() }}">
            
            <!-- Paddy Type Dropdown -->
            <div class="space-y-1 sm:space-y-2">
                <label for="PaddyType" class="block text-sm sm:text-base font-bold text-gray-700">Select Paddy Type</label>
                <select name="PaddyID" id="PaddyType" class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md sm:rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all text-sm sm:text-base">
                    <option value="" disabled selected>Choose paddy variety</option>
                    @foreach($paddyTypes as $type)
                        <option value="{{ $type->PaddyID }}" 
                                data-max-price="{{ $type->MaxPricePerKg }}" 
                                data-image="{{ $type->Image ? asset('storage/'.$type->Image) : '' }}" 
                                data-name="{{ $type->PaddyName }}">
                            {{ $type->PaddyName }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Dynamic Content Area -->
            <div id="paddyDetails" class="space-y-4 sm:space-y-8">
                <!-- Price Slider -->
                <div class="space-y-2 sm:space-y-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                        <label class="block text-sm sm:text-base font-bold text-gray-700">Price Per Kg (Rs.)</label>
                        <span id="selectedPrice" class="px-2 py-1 sm:px-3 sm:py-1.5 bg-green-100 text-green-800 rounded-md text-xs sm:text-sm font-medium">Select type first</span>
                    </div>
                    <input type="range" name="PriceSelected" id="PriceSelected" min="0" max="0" value="0" 
                           class="w-full h-2 sm:h-2.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-green-600">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Minimum</span>
                        <span id="maxPriceLabel">Maximum: Rs. 0</span>
                    </div>
                </div>

                <!-- Paddy Image Preview -->
                <div id="imagePreview" class="hidden mt-4 sm:mt-6">
                    <div class="flex justify-center">
                        <img id="paddyImage" src="" alt="Paddy Image" 
                             class="w-36 h-36 sm:w-48 sm:h-48 object-cover rounded-lg border border-gray-200 shadow-sm"
                             onerror="this.onerror=null;this.src='{{ asset('images/default-paddy.jpg') }}'">
                    </div>
                </div>

                <!-- Quantity Input -->
                <div class="space-y-1 sm:space-y-2">
                    <label for="Quantity" class="block text-sm sm:text-base font-bold text-gray-700">Available Quantity (kg)</label>
                    <input type="number" name="Quantity" id="Quantity" min="1" 
                           class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md sm:rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all text-sm sm:text-base" required>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-row justify-between gap-6 pt-4 ">
                <button type="button" onclick="window.location.href='{{ route('farmer.paddy.listing') }}'" 
                        class="px-4 py-2 sm:px-6 sm:py-3 bg-gray-200 text-gray-800 rounded-md sm:rounded-lg hover:bg-gray-300 transition-all font-medium text-sm sm:text-base shadow-sm">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 sm:px-6 sm:py-3 bg-green-700 text-white rounded-md sm:rounded-lg hover:bg-green-800 transition-all font-medium text-sm sm:text-base shadow-sm">
                    Add
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paddyTypeDropdown = document.getElementById('PaddyType');
        const priceSlider = document.getElementById('PriceSelected');
        const selectedPriceDisplay = document.getElementById('selectedPrice');
        const maxPriceLabel = document.getElementById('maxPriceLabel');
        const paddyImage = document.getElementById('paddyImage');
        const imagePreview = document.getElementById('imagePreview');

        paddyTypeDropdown.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const maxPrice = selectedOption.getAttribute('data-max-price');
            const imageUrl = selectedOption.getAttribute('data-image');
            const name = selectedOption.getAttribute('data-name');

            // Update price slider
            priceSlider.max = maxPrice;
            priceSlider.value = maxPrice;
            selectedPriceDisplay.textContent = `Rs. ${maxPrice}`;
            maxPriceLabel.textContent = `Maximum: Rs. ${maxPrice}`;

            // Update image
            if (imageUrl) {
                paddyImage.src = imageUrl;
                paddyImage.alt = `${name} image`;
                imagePreview.classList.remove('hidden');
                
                // Verify image loads
                paddyImage.onerror = function() {
                    console.error('Failed to load image:', imageUrl);
                    this.src = '{{ asset('images/default-paddy.jpg') }}';
                };
            } else {
                imagePreview.classList.add('hidden');
            }
        });

        priceSlider.addEventListener('input', function() {
            selectedPriceDisplay.textContent = `Rs. ${this.value}`;
        });
    });
</script>
@endsection