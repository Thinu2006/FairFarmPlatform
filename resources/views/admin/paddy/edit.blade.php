<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paddy Type</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('../../../app/Images/bg.jpg') no-repeat center center/cover;
        }
    </style>
    <script>
        function updatePrice() {
            const max = document.getElementById('Price').value;
            document.getElementById('priceDisplay').textContent = `Rs.${max}`;
        }

        function triggerFileInput() {
            document.getElementById('paddyImage').click();
        }

        function previewImage(event) {
            const image = document.getElementById('imagePreview');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.classList.remove('hidden');
        }
    </script>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="max-w-2xl w-full p-10 bg-white bg-opacity-90 border border-gray-300 shadow-2xl rounded-lg">
        <h1 class="text-4xl font-bold text-center mb-8 text-green-800">Edit Paddy Type</h1>
        <form action="{{ route('admin.paddy.update', $paddy->PaddyID) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Paddy Name -->
            <div>
                <label class="block text-lg font-bold mb-2">Paddy Name</label>
                <input type="text" name="PaddyName" class="w-full p-2 border rounded bg-gray-100" 
                       value="{{ old('PaddyName', $paddy->PaddyName) }}" required>
            </div>
            
            <!-- Maximum Price -->
            <div>
                <label class="block text-lg font-bold mb-2">Maximum Price</label>
                <div class="flex justify-between space-x-4 items-center">
                    <span>Rs.0</span>
                    <input type="range" id="Price" name="MaxPricePerKg" max="1000" 
                           value="{{ old('MaxPricePerKg', $paddy->MaxPricePerKg) }}" 
                           oninput="updatePrice()" class="w-full">
                    <span>Rs.1000</span>
                </div>
                <p id="priceDisplay" class="text-center font-bold mt-2">Rs.{{ old('MaxPricePerKg', $paddy->MaxPricePerKg) }}</p>
            </div>

            <!-- Image Upload -->
            <div class="mt-6">
                <label class="block text-lg font-bold mb-2">Paddy Image</label>
                <div class="flex flex-col items-center">
                    @if ($paddy->Image)
                        <img id="imagePreview" class="max-h-60 rounded-lg shadow-md mb-4" 
                             src="{{ asset('storage/' . $paddy->Image) }}" alt="Current Image">
                    @else
                        <img id="imagePreview" class="hidden max-h-60 rounded-lg shadow-md mb-4" 
                             src="#" alt="Current Image">
                    @endif
                    <div class="border-2 border-dashed border-gray-400 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-100 transition w-full text-center" onclick="triggerFileInput()">
                        <p class="text-gray-500">Click to upload or drag and drop</p>
                    </div>
                </div>
                <input type="file" id="paddyImage" name="Image" class="hidden" accept="image/*" onchange="previewImage(event)">
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-between mt-6">
                <button type="button" onclick="window.history.back()" class="bg-gray-500 text-white py-2 px-6 rounded hover:bg-gray-700 transition">Back</button>
                <button type="submit" class="bg-green-600 text-white py-2 px-6 rounded hover:bg-green-800 transition">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
