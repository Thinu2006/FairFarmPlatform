<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Paddy Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function updatePrice() {
            const max = document.getElementById('MaxPricePerKg').value;
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
<body class="bg-cover bg-opacity-90 bg-[#F5EFE6] bg-center flex items-center justify-center min-h-screen p-4" style="background-image: url('../../Images/BuyerLoginBG.jpg')">
    <div class="bg-white border border-gray-300 shadow-2xl rounded-xl p-10 max-w-3xl w-full">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Create Paddy Record</h1>
        <form action="{{ route('admin.paddy.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('post')

            <div>
                <label for="PaddyName" class="block text-lg font-bold text-gray-700 mb-2">Paddy Type</label>
                <input type="text" name="PaddyName" class="w-full p-2 border rounded bg-gray-100 focus:ring-2 focus:ring-green-400" required>
            </div>

            <div>
                <label for="MaxPricePerKg" class="block text-lg font-bold text-gray-700 mb-2">Max Price (per kg)</label>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Rs.0</span>
                    <input type="range" id="MaxPricePerKg" name="MaxPricePerKg" max="1000" value="0" oninput="updatePrice()" class="w-full">
                    <span class="text-gray-600">Rs.1000</span>
                </div>
                <p id="priceDisplay" class="text-center font-bold text-gray-800">Rs.0</p>
            </div>

            <div>
                <label for="Image" class="block text-lg font-bold text-gray-700 mb-2">Image</label>
                <div class="border-2 border-dashed border-gray-400 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-100 transition" onclick="triggerFileInput()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <p class="text-gray-500">Click to upload or drag and drop</p>
                </div>
                <input type="file" id="paddyImage" name="Image" class="hidden" accept="image/*" onchange="previewImage(event)">
                <img id="imagePreview" class="hidden mt-4 rounded-lg shadow-md max-h-48 w-full object-cover">
            </div>

            <div class="flex justify-between items-center">
                <button type="button" onclick="window.history.back()" class="bg-gray-400 text-white py-2 px-6 rounded hover:bg-gray-500 transition">Back</button>
                <button type="submit" class="bg-green-700 text-white py-2 px-6 rounded hover:bg-green-800 transition">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>