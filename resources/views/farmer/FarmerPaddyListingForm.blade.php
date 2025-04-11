<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Paddy Record</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
<body>
<style>
    .blur-background {
        position: relative;
    }
    .blur-background::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6)), url('{{ asset('images/FarmerLoginBG.jpg') }}') no-repeat center center/cover;
        z-index: -1;
    }
    .form-container {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(2px);
    }
    input[type="range"] {
        -webkit-appearance: none;
        height: 8px;
        border-radius: 5px;
        background: white;
    }
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: #15803d;
        border-radius: 50%;
        cursor: pointer;
    }
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .border-error {
        border-color: #ef4444;
    }
</style>

<main class="blur-background flex items-center justify-center min-h-screen p-4 md:p-8">
    <div class="form-container w-full max-w-2xl rounded-2xl shadow-xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-700 to-green-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white text-center">List New Paddy Type</h1>
            <p class="text-green-100 text-sm text-center mt-1">Fill out the form to list a new paddy type for sale</p>
        </div>
        
        <!-- Form Section -->
        <div class="p-6 md:p-8">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 flex items-center justify-center" role="alert">
                    <span class="text-center">{{ session('error') }}</span>
                </div>
            @endif
            
            <form action="{{ route('farmer.selling.paddy.store') }}" method="POST" id="sellingForm" class="space-y-6" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="FarmerID" value="{{ auth()->id() }}">
                
                <!-- Paddy Type Dropdown -->
                <div class="space-y-2">
                    <label for="PaddyType" class="block text-base font-medium text-gray-700">Select Paddy Type <span class="text-red-500">*</span></label>
                    <select name="PaddyID" id="PaddyType" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-base" required>
                        <option value="" disabled selected>Choose paddy variety</option>
                        @foreach($paddyTypes as $type)
                            <option value="{{ $type->PaddyID }}" 
                                    data-min-price="{{ $type->MinPricePerKg }}"
                                    data-max-price="{{ $type->MaxPricePerKg }}" 
                                    data-image="{{ $type->Image ? asset('storage/'.$type->Image) : '' }}" 
                                    data-name="{{ $type->PaddyName }}">
                                {{ $type->PaddyName }}
                            </option>
                        @endforeach
                    </select>
                    <div id="paddyTypeError" class="error-message"></div>
                </div>
                
                <!-- Price Slider -->
                <div class="space-y-4">
                    <label class="block text-base font-medium text-gray-700">Price Per Kg (Rs.) <span class="text-red-500">*</span></label>
                    <div class="flex items-center justify-between mb-2">
                        <span id="minPriceLabel" class="text-sm text-gray-500">Minimum: Rs. 0</span>
                        <span id="selectedPrice" class="text-sm font-semibold">Select type first</span>
                        <span id="maxPriceLabel" class="text-sm text-gray-500">Maximum: Rs. 0</span>
                    </div>
                    <input type="range" name="PriceSelected" id="PriceSelected" min="0" max="0" value="0" 
                           class="w-full" required>
                    <div id="priceError" class="error-message"></div>
                </div>

                <!-- Paddy Image Preview -->
                <div id="imagePreviewContainer" class="hidden space-y-2">
                    <label class="block text-base font-medium text-gray-700">Paddy Image</label>
                    <div class="relative">
                        <img id="paddyImage" src="" alt="Paddy Image" 
                             class="w-full h-40 object-cover rounded-lg border border-gray-200">
                    </div>
                </div>

                <!-- Quantity Input -->
                <div class="space-y-2">
                    <label for="Quantity" class="block text-base font-medium text-gray-700">Available Quantity (kg) <span class="text-red-500">*</span></label>
                    <input type="number" name="Quantity" id="Quantity" min="1" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-base" required>
                    <div id="quantityError" class="error-message"></div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between pt-4">
                    <button type="button" onclick="window.location.href='{{ route('farmer.paddy.listing') }}'" 
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Listing
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paddyTypeDropdown = document.getElementById('PaddyType');
        const priceSlider = document.getElementById('PriceSelected');
        const selectedPriceDisplay = document.getElementById('selectedPrice');
        const minPriceLabel = document.getElementById('minPriceLabel');
        const maxPriceLabel = document.getElementById('maxPriceLabel');
        const paddyImage = document.getElementById('paddyImage');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const quantityInput = document.getElementById('Quantity');

        // Initialize form validation
        setupValidation();

        paddyTypeDropdown.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const minPrice = selectedOption.getAttribute('data-min-price');
            const maxPrice = selectedOption.getAttribute('data-max-price');
            const imageUrl = selectedOption.getAttribute('data-image');
            const name = selectedOption.getAttribute('data-name');

            if (!minPrice || !maxPrice || isNaN(minPrice) || isNaN(maxPrice)) {
                showError('priceError', 'Invalid paddy type selected');
                return;
            }

            // Update price slider
            priceSlider.min = minPrice;
            priceSlider.max = maxPrice;
            priceSlider.value = maxPrice;
            selectedPriceDisplay.textContent = `Rs. ${maxPrice}`;
            selectedPriceDisplay.classList.add('text-green-600', 'font-bold');
            minPriceLabel.textContent = `Minimum: Rs. ${minPrice}`;
            maxPriceLabel.textContent = `Maximum: Rs. ${maxPrice}`;
            clearError('priceError');

            // Update image
            if (imageUrl) {
                paddyImage.src = imageUrl;
                paddyImage.alt = `${name} image`;
                imagePreviewContainer.classList.remove('hidden');
                
                paddyImage.onerror = function() {
                    this.src = '{{ asset('images/default-paddy.jpg') }}';
                };
            } else {
                paddyImage.src = '{{ asset('images/default-paddy.jpg') }}';
                imagePreviewContainer.classList.remove('hidden');
            }
        });

        priceSlider.addEventListener('input', function() {
            selectedPriceDisplay.textContent = `Rs. ${this.value}`;
            validatePrice();
        });

        quantityInput.addEventListener('input', validateQuantity);
    });

    function setupValidation() {
        // Add event listeners for validation
        document.getElementById('PaddyType').addEventListener('change', validatePaddyType);
        document.getElementById('PriceSelected').addEventListener('change', validatePrice);
        document.getElementById('Quantity').addEventListener('input', validateQuantity);
    }

    function validateForm() {
        let isValid = true;
        
        isValid = validatePaddyType() && isValid;
        isValid = validatePrice() && isValid;
        isValid = validateQuantity() && isValid;
        
        if (!isValid) {
            // Scroll to the first error
            const firstError = document.querySelector('.error-message:not(:empty)');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        return isValid;
    }

    function validatePaddyType() {
        const paddyType = document.getElementById('PaddyType');
        const errorElement = document.getElementById('paddyTypeError');
        
        if (!paddyType.value) {
            showError('paddyTypeError', 'Please select a paddy type');
            paddyType.classList.add('border-error');
            return false;
        }
        
        clearError('paddyTypeError');
        paddyType.classList.remove('border-error');
        return true;
    }

    function validatePrice() {
        const priceSlider = document.getElementById('PriceSelected');
        const errorElement = document.getElementById('priceError');
        const price = parseFloat(priceSlider.value);
        const minPrice = parseFloat(priceSlider.min);
        const maxPrice = parseFloat(priceSlider.max);
        
        if (isNaN(price) || price <= 0) {
            showError('priceError', 'Please set a valid price');
            return false;
        }
        
        if (price < minPrice) {
            showError('priceError', `Price cannot be less than Rs. ${minPrice}`);
            return false;
        }
        
        if (price > maxPrice) {
            showError('priceError', `Price cannot exceed Rs. ${maxPrice}`);
            return false;
        }
        
        clearError('priceError');
        return true;
    }

    function validateQuantity() {
        const quantityInput = document.getElementById('Quantity');
        const errorElement = document.getElementById('quantityError');
        const quantity = parseFloat(quantityInput.value);
        
        if (isNaN(quantity) || quantity <= 0) {
            showError('quantityError', 'Please enter a valid quantity (minimum 1kg)');
            quantityInput.classList.add('border-error');
            return false;
        }
        
        if (!Number.isInteger(quantity)) {
            showError('quantityError', 'Quantity must be a whole number');
            quantityInput.classList.add('border-error');
            return false;
        }
        
        clearError('quantityError');
        quantityInput.classList.remove('border-error');
        return true;
    }

    function showError(elementId, message) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = message;
        }
    }

    function clearError(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = '';
        }
    }
</script>
</body>
</html>