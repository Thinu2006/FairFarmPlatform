<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paddy Type</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../../../app/Images/bg.jpg') no-repeat center center/cover;
            min-height: 100vh;
            backdrop-filter: blur(8px);
        }
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
            background: inherit;
            filter: blur(8px);
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
        .border-red-500 {
            border-color: #ef4444;
        }
        #imageError {
            min-height: 20px;
            visibility: hidden;
        }
        #imageError:not(.hidden) {
            visibility: visible;
        }
    </style>
    <script>
        function updateMinPrice() {
            const min = document.getElementById('MinPricePerKg').value;
            document.getElementById('minPriceDisplay').textContent = `Rs. ${min}`;
            
            // Add animation
            document.getElementById('minPriceDisplay').classList.add('scale-110', 'transition-transform', 'duration-200');
            setTimeout(() => {
                document.getElementById('minPriceDisplay').classList.remove('scale-110');
            }, 200);
            
            // Ensure max is always greater than min
            const maxInput = document.getElementById('MaxPricePerKg');
            if (parseFloat(maxInput.value) <= parseFloat(min)) {
                maxInput.value = parseFloat(min) + 5;
                updateMaxPrice();
            }
        }

        function updateMaxPrice() {
            const max = document.getElementById('MaxPricePerKg').value;
            document.getElementById('maxPriceDisplay').textContent = `Rs. ${max}`;
            
            // Add animation
            document.getElementById('maxPriceDisplay').classList.add('scale-110', 'transition-transform', 'duration-200');
            setTimeout(() => {
                document.getElementById('maxPriceDisplay').classList.remove('scale-110');
            }, 200);
            
            // Ensure min is always less than max
            const minInput = document.getElementById('MinPricePerKg');
            if (parseFloat(minInput.value) >= parseFloat(max)) {
                minInput.value = parseFloat(max) - 5;
                updateMinPrice();
            }
        }

        function triggerFileInput() {
            document.getElementById('paddyImage').click();
        }

        function previewImage(event) {
            const image = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = event.target;
            const file = fileInput.files[0];
            
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    showImageError('Please upload a valid image (JPEG, PNG, JPG)');
                    fileInput.value = '';
                    return;
                }
                
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    showImageError('Image size must be less than 2MB');
                    fileInput.value = '';
                    return;
                }
                
                clearImageError();
                image.src = URL.createObjectURL(file);
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
                uploadArea.classList.add('hidden');
            }
        }

        function removeImage() {
            const image = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('uploadArea');
            image.classList.add('hidden');
            uploadArea.classList.remove('hidden');
            document.getElementById('paddyImage').value = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            clearImageError();
        }

        function showImageError(message) {
            const uploadArea = document.getElementById('uploadArea');
            const errorElement = document.getElementById('imageError');
            
            // Show error message and style upload area
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            uploadArea.classList.add('border-red-500', 'bg-red-50');
            uploadArea.classList.remove('border-gray-300', 'hover:bg-gray-50');
        }

        function clearImageError() {
            const uploadArea = document.getElementById('uploadArea');
            const errorElement = document.getElementById('imageError');
            
            // Hide error message and reset upload area style
            errorElement.classList.add('hidden');
            uploadArea.classList.remove('border-red-500', 'bg-red-50');
            uploadArea.classList.add('border-gray-300', 'hover:bg-gray-50');
        }

        function validateForm(event) {
            let isValid = true;
            
            // Validate Paddy Name
            const paddyName = document.getElementById('PaddyName').value.trim();
            if (!paddyName) {
                showError('PaddyName', 'Paddy type name is required');
                isValid = false;
            } else if (paddyName.length > 100) {
                showError('PaddyName', 'Name must be less than 100 characters');
                isValid = false;
            } else {
                clearError('PaddyName');
            }
            
            // Validate Min Price
            const minPrice = document.getElementById('MinPricePerKg').value;
            if (!minPrice || minPrice <= 0) {
                showError('MinPricePerKg', 'Minimum price must be greater than 0');
                isValid = false;
            } else if (minPrice > 1000) {
                showError('MinPricePerKg', 'Minimum price must be less than Rs. 1000');
                isValid = false;
            } else {
                clearError('MinPricePerKg');
            }
            
            // Validate Max Price
            const maxPrice = document.getElementById('MaxPricePerKg').value;
            if (!maxPrice || maxPrice <= 0) {
                showError('MaxPricePerKg', 'Maximum price must be greater than 0');
                isValid = false;
            } else if (maxPrice > 1000) {
                showError('MaxPricePerKg', 'Maximum price must be less than Rs. 1000');
                isValid = false;
            } else if (parseFloat(maxPrice) <= parseFloat(minPrice)) {
                showError('MaxPricePerKg', 'Maximum price must be greater than minimum price');
                isValid = false;
            } else {
                clearError('MaxPricePerKg');
            }
            
            // Validate Image
            const fileInput = document.getElementById('paddyImage');
            if (!fileInput || (fileInput.files.length === 0 && !document.getElementById('imagePreview').src.includes('storage/'))) {
                showImageError('Please select an image to upload');
                isValid = false;
            } else {
                clearImageError();
            }
            
            if (!isValid) {
                event.preventDefault();
                // Scroll to the first error
                const firstError = document.querySelector('.text-red-600:not(.hidden)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            
            return isValid;
        }

        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById(`${fieldId}-error`);
            
            if (errorElement) {
                errorElement.textContent = message;
            } else {
                const div = document.createElement('div');
                div.id = `${fieldId}-error`;
                div.className = 'mt-1 text-sm text-red-600';
                div.textContent = message;
                field.parentNode.appendChild(div);
            }
            
            field.classList.add('border-red-500');
            field.classList.remove('border-gray-300');
        }

        function clearError(fieldId) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById(`${fieldId}-error`);
            
            if (errorElement) {
                errorElement.remove();
            }
            
            field.classList.remove('border-red-500');
            field.classList.add('border-gray-300');
        }

        // Initialize form validation on load
        document.addEventListener('DOMContentLoaded', function() {
            // Add validation on blur for text input
            document.getElementById('PaddyName').addEventListener('blur', function() {
                const value = this.value.trim();
                if (!value) {
                    showError('PaddyName', 'Paddy type name is required');
                } else if (value.length > 100) {
                    showError('PaddyName', 'Name must be less than 100 characters');
                } else {
                    clearError('PaddyName');
                }
            });
            
            // Clear image error when clicking upload area
            document.getElementById('uploadArea').addEventListener('click', function() {
                clearImageError();
            });
            
            // Initialize price displays
            updateMinPrice();
            updateMaxPrice();
        });
    </script>
</head>
<body class="blur-background flex items-center justify-center min-h-screen p-4 md:p-8">
    <div class="form-container w-full max-w-2xl rounded-2xl shadow-xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-green-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white text-center">
                Edit Paddy Type
            </h1>
        </div>
        
        <!-- Form Section -->
        <div class="p-6">
            <form action="{{ route('admin.paddy.update', $paddy->PaddyID) }}" method="post" enctype="multipart/form-data" class="space-y-6" onsubmit="return validateForm(event)">
                @csrf
                @method('PUT')

                <!-- Paddy Name -->
                <div class="space-y-2">
                    <label for="PaddyName" class="block text-base font-medium text-gray-700">Paddy Type Name <span class="text-red-500">*</span></label>
                    <input type="text" name="PaddyName" id="PaddyName" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                           value="{{ old('PaddyName', $paddy->PaddyName) }}" 
                           placeholder="Enter paddy variety name" required
                           maxlength="100">
                </div>

                <!-- Price Range Section -->
                <div class="space-y-6">
                    <h3 class="text-base font-medium text-gray-700">Price Range (per kg) <span class="text-red-500">*</span></h3>
                    
                    <!-- Minimum Price -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Minimum Price</label>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Rs. 0</span>
                            <span id="minPriceDisplay" class="text-sm font-semibold">Rs. {{ old('MinPricePerKg', $paddy->MinPricePerKg) }}</span>
                            <span class="text-sm text-gray-500">Rs. 1000</span>
                        </div>
                        <input type="range" id="MinPricePerKg" name="MinPricePerKg" 
                               min="1" max="1000" value="{{ old('MinPricePerKg', $paddy->MinPricePerKg) }}" step="5" 
                               oninput="updateMinPrice()" 
                               class="w-full">
                    </div>
                    
                    <!-- Maximum Price -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Maximum Price</label>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Rs. 0</span>
                            <span id="maxPriceDisplay" class="text-sm font-semibold">Rs. {{ old('MaxPricePerKg', $paddy->MaxPricePerKg) }}</span>
                            <span class="text-sm text-gray-500">Rs. 1000</span>
                        </div>
                        <input type="range" id="MaxPricePerKg" name="MaxPricePerKg" 
                               min="1" max="1000" value="{{ old('MaxPricePerKg', $paddy->MaxPricePerKg) }}" step="5" 
                               oninput="updateMaxPrice()" 
                               class="w-full">
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="space-y-2">
                    <label class="block text-base font-medium text-gray-700">Paddy Image <span class="text-red-500">*</span></label>
                    <!-- Image Preview -->
                    <div id="imagePreviewContainer" class="{{ $paddy->Image ? '' : 'hidden' }} relative mt-2">
                        <img id="imagePreview" class="w-full h-40 object-cover rounded-lg border border-gray-200" 
                             src="{{ $paddy->Image ? asset('storage/' . $paddy->Image) : '#' }}">
                        <button type="button" onclick="removeImage()" 
                                class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <div id="uploadArea" onclick="triggerFileInput()" 
                         class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 transition">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500 text-center">
                            <span class="font-medium text-green-600">Click to upload</span> or drag and drop<br>
                            <span class="text-xs">PNG, JPG, JPEG (Max 2MB)</span>
                        </p>
                    </div>
                    <!-- Error message container -->
                    <div id="imageError" class="hidden mt-1 text-sm text-red-600"></div>
                    
                    <input type="file" id="paddyImage" name="Image" class="hidden" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(event)">
                    <input type="hidden" id="removeImageFlag" name="remove_image" value="0">
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between pt-4">
                    <button type="button" onclick="window.history.back()" 
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition flex items-center">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>