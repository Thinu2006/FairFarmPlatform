<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paddy Record</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        .font-merriweather {
            font-family: 'Merriweather', serif;
        }
        .blur-background {
            position: relative;
            min-height: 100vh;
        }
        .blur-background::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/FarmerLoginBG.jpg') }}') no-repeat center center/cover;
            filter: blur(8px);
            z-index: -1;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        input[type="range"] {
            -webkit-appearance: none;
            height: 8px;
            border-radius: 5px;
            background: #e5e7eb;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #15803d;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.1);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .border-error {
            border-color: #ef4444;
        }
        .info-card {
            background-color: rgba(236, 253, 245, 0.7);
            border: 1px solid rgba(167, 243, 208, 0.5);
            transition: all 0.3s ease;
        }
        .info-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        .btn-primary {
            background-image: linear-gradient(to right, #059669, #047857);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-image: linear-gradient(to right, #047857, #065f46);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2);
        }
        .btn-secondary {
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 640px) {
            .blur-background::before {
                background-attachment: scroll;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Main Content -->
    <main class="blur-background flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-2xl lg:max-w-4xl mx-auto">
            <div class="form-container rounded-xl sm:rounded-2xl overflow-hidden border border-gray-200">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-green-700 to-green-600 px-6 py-6 sm:py-8 text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 font-merriweather">Edit Paddy Listing</h1>
                </div>

                <!-- Form Section -->
                <form action="{{ route('farmer.paddy.listing.update', $paddyListing->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-4 space-y-2">
                    @csrf
                    @method('PUT')

                    <!-- Hidden PaddyID Field -->
                    <input type="hidden" name="PaddyID" value="{{ $paddyListing->PaddyID }}">

                    <!-- Paddy Type Display -->
                    <div class="info-card p-4 sm:p-5 rounded-lg">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3">
                            <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                <i class="fas fa-seedling text-green-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm font-medium text-green-600">PADDY TYPE</p>
                                <h3 class="text-lg sm:text-xl font-bold text-green-800 font-merriweather">{{ $paddyListing->paddyType->PaddyName }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Price Slider Section -->
                    <div class="info-card p-4 sm:p-5 rounded-lg space-y-4">
                        <div>
                            <label class="block text-sm sm:text-base font-semibold text-green-700 mb-1">Price Per Kilogram</label>
                        </div>
                        
                        <!-- Max Price Indicator -->
                        <div class="flex justify-between items-center bg-green-50 px-3 py-2 rounded">
                            <span class="text-sm font-medium text-green-700">Maximum Price:</span>
                            <span class="text-sm font-bold text-green-800">Rs. <span id="maxPriceDisplay">{{ $paddyListing->paddyType->MaxPricePerKg }}</span></span>
                        </div>
                        
                        <!-- Price Slider -->
                        <div class="px-2 sm:px-4">
                            <input type="range" name="PriceSelected" id="PriceSelected" 
                                   min="0" max="{{ $paddyListing->paddyType->MaxPricePerKg }}" 
                                   value="{{ $paddyListing->PriceSelected }}" 
                                   class="w-full h-2 sm:h-2.5">
                        </div>
                        
                        <!-- Selected Price Display -->
                        <div class="flex justify-between items-center bg-green-100 px-4 py-3 rounded-lg">
                            <span class="text-sm font-medium text-green-700">Your Price:</span>
                            <span class="text-lg font-bold text-green-800">Rs. <span id="dynamicPriceDisplay">{{ $paddyListing->PriceSelected }}</span></span>
                        </div>
                    </div>

                    <!-- Quantity Input -->
                    <div class="info-card p-4 sm:p-5 rounded-lg space-y-3">
                        <label for="Quantity" class="block text-sm sm:text-base font-semibold text-green-700">Available Quantity (kg)</label>
                        <div class="relative">
                            <input type="number" name="Quantity" id="Quantity" 
                                   value="{{ $paddyListing->Quantity }}" min="1" 
                                   class="w-full px-4 py-2 sm:py-3 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700">
                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">kg</span>
                        </div>
                        <p class="text-xs text-green-600">Enter the total kilograms available for sale</p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
                        <button type="button" onclick="window.location.href='{{ route('farmer.paddy.listing') }}'" 
                                class="btn-secondary px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium shadow-sm text-sm sm:text-base border border-gray-200">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Listings
                        </button>
                        <button type="submit" 
                                class="btn-primary px-6 py-3 text-white rounded-lg font-medium shadow-sm text-sm sm:text-base">
                            <i class="fas fa-save mr-2"></i> Update Listing
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Function to update the price display
        function updatePriceDisplay() {
            const priceSlider = document.getElementById('PriceSelected');
            const dynamicPriceDisplay = document.getElementById('dynamicPriceDisplay');
            dynamicPriceDisplay.textContent = priceSlider.value;
            
            // Add visual feedback when changing price
            dynamicPriceDisplay.classList.add('text-green-600', 'scale-105');
            setTimeout(() => {
                dynamicPriceDisplay.classList.remove('scale-105');
            }, 200);
        }

        // Initialize price display on page load
        document.addEventListener('DOMContentLoaded', function () {
            updatePriceDisplay();
            
            // Update price display when slider moves
            const priceSlider = document.getElementById('PriceSelected');
            priceSlider.addEventListener('input', updatePriceDisplay);
            
            // Add touch support for mobile devices
            priceSlider.addEventListener('touchstart', function() {
                this.classList.add('active');
            });
            priceSlider.addEventListener('touchend', function() {
                this.classList.remove('active');
            });
        });

        // Add animation to quantity input when focused
        document.getElementById('Quantity').addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-green-300');
        });
        document.getElementById('Quantity').addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-green-300');
        });
    </script>
</body>
</html>