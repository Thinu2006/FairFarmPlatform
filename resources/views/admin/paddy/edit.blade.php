<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paddy Type</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../../../app/Images/bg.jpg') no-repeat center center/cover;
            min-height: 100vh;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 18px;
            width: 18px;
            background: #16a34a;
            border-radius: 50%;
            cursor: pointer;
        }
        .drop-zone {
            transition: all 0.3s ease;
            min-height: 150px;
        }
        .drop-zone.active {
            border-color: #16a34a;
            background-color: rgba(22, 163, 74, 0.05);
        }
        .image-container {
            position: relative;
            display: inline-block;
        }
        .remove-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 md:p-8">
    <div class="w-full max-w-3xl bg-white bg-opacity-95 border border-gray-200 rounded-xl shadow-lg overflow-hidden">
        <!-- Header Section -->
        <div class="bg-green-700 px-6 py-4">
            <h1 class="text-2xl md:text-3xl font-bold text-white text-center">
                <i class="fas fa-edit mr-2"></i> Edit Paddy Type
            </h1>
        </div>

        <!-- Form Section -->
        <form action="{{ route('admin.paddy.update', $paddy->PaddyID) }}" method="post" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Paddy Name -->
            <div class="space-y-2">
                <label class="block text-base font-medium text-gray-700">
                    Paddy Name <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-seedling text-gray-400"></i>
                    </div>
                    <input type="text" name="PaddyName" 
                           class="block w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                           value="{{ old('PaddyName', $paddy->PaddyName) }}" 
                           required
                           placeholder="Enter paddy variety name">
                </div>
                @error('PaddyName')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Maximum Price -->
            <div class="space-y-4">
                <label class="block text-base font-medium text-gray-700">
                    Maximum Price (per kg) <span class="text-red-500">*</span>
                </label>
                
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>Rs. 0</span>
                    <span>Rs. 1000</span>
                </div>
                
                <input type="range" id="Price" name="MaxPricePerKg" 
                       min="0" max="1000" step="1"
                       value="{{ old('MaxPricePerKg', $paddy->MaxPricePerKg) }}" 
                       oninput="updatePrice()" 
                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                
                <div class="text-center">
                    <span id="priceDisplay" class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                        Rs. {{ old('MaxPricePerKg', $paddy->MaxPricePerKg) }}
                    </span>
                </div>
                @error('MaxPricePerKg')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="space-y-4">
                <label class="block text-base font-medium text-gray-700">
                    Paddy Image
                </label>
                
                <div class="flex flex-col items-center space-y-4">
                    <div class="relative">
                        @if ($paddy->Image)
                            <div class="image-container">
                                <img id="imagePreview" 
                                     class="max-h-48 md:max-h-60 w-auto rounded-lg shadow border border-gray-200" 
                                     src="{{ asset('storage/' . $paddy->Image) }}" 
                                     alt="Current Paddy Image">
                                <div class="remove-image" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        @else
                            <img id="imagePreview" 
                                 class="hidden max-h-48 md:max-h-60 w-auto rounded-lg shadow border border-gray-200" 
                                 src="#" 
                                 alt="New Paddy Image">
                        @endif
                    </div>
                    
                    <div id="dropZone" class="drop-zone w-full border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:border-green-500 transition-colors"
                         onclick="triggerFileInput()">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                        <p class="text-sm md:text-base text-gray-600 font-medium text-center">
                            Click to upload or drag and drop your image here
                        </p>
                        <p class="text-xs text-gray-400 mt-2">
                            Supports: JPG, PNG (Max 5MB)
                        </p>
                    </div>
                </div>
                
                <input type="file" id="paddyImage" name="Image" 
                       class="hidden" 
                       accept="image/png, image/jpeg" 
                       onchange="previewImage(event)">
                <input type="hidden" id="removeImageFlag" name="remove_image" value="0">
                @error('Image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col-reverse sm:flex-row justify-between gap-4 pt-4">
                <button type="button" 
                        onclick="window.history.back()" 
                        class="flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
                <button type="submit" 
                        class="flex items-center justify-center px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i> Update Paddy
                </button>
            </div>
        </form>
    </div>

    <script>
        // Price Range Update
        function updatePrice() {
            const price = document.getElementById('Price').value;
            const display = document.getElementById('priceDisplay');
            display.textContent = `Rs. ${price}`;
            
            // Add animation
            display.classList.add('scale-110', 'transition-transform', 'duration-200');
            setTimeout(() => {
                display.classList.remove('scale-110');
            }, 200);
        }

        // Image Upload Handling
        function triggerFileInput() {
            document.getElementById('paddyImage').click();
        }

        function previewImage(event) {
            const image = document.getElementById('imagePreview');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    image.classList.remove('hidden');
                    
                    // Add remove button if not existing
                    if (!image.parentElement.querySelector('.remove-image')) {
                        const removeBtn = document.createElement('div');
                        removeBtn.className = 'remove-image';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        removeBtn.onclick = removeImage;
                        image.parentElement.appendChild(removeBtn);
                    }
                    
                    // Reset remove image flag
                    document.getElementById('removeImageFlag').value = '0';
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function removeImage() {
            const image = document.getElementById('imagePreview');
            image.src = '#';
            image.classList.add('hidden');
            
            // Remove the file from input
            document.getElementById('paddyImage').value = '';
            
            // Remove the remove button
            const removeBtn = image.parentElement.querySelector('.remove-image');
            if (removeBtn) {
                removeBtn.remove();
            }
            
            // Set flag to remove existing image
            document.getElementById('removeImageFlag').value = '1';
        }

        // Drag and Drop Functionality
        document.addEventListener('DOMContentLoaded', () => {
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('paddyImage');

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop zone when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropZone.classList.add('active');
                dropZone.innerHTML = `
                    <i class="fas fa-file-upload text-3xl text-green-500 mb-3"></i>
                    <p class="text-sm md:text-base text-gray-600 font-medium text-center">
                        Drop your image here to upload
                    </p>
                `;
            }

            function unhighlight() {
                dropZone.classList.remove('active');
                dropZone.innerHTML = `
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                    <p class="text-sm md:text-base text-gray-600 font-medium text-center">
                        Click to upload or drag and drop your image here
                    </p>
                    <p class="text-xs text-gray-400 mt-2">
                        Supports: JPG, PNG (Max 5MB)
                    </p>
                `;
            }

            // Handle dropped files
            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length) {
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png'];
                    if (!validTypes.includes(files[0].type)) {
                        alert('Please upload only JPG or PNG images');
                        return;
                    }
                    
                    // Validate file size (5MB)
                    if (files[0].size > 5 * 1024 * 1024) {
                        alert('File size should not exceed 5MB');
                        return;
                    }
                    
                    fileInput.files = files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            }
        });
    </script>
</body>
</html>