<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto+Slab:wght@400;600&display=swap');
        
        body {
            font-family: "Roboto Slab", serif;
        }
        h1, h2 {
            font-family: "Playfair Display", serif;
        }
    </style>
</head>
<body class="bg-cover bg-center min-h-screen flex justify-center items-center px-4" 
      style="background-image: url('./../../Images/admin.jpg');">

    <div class="bg-white shadow-lg rounded-lg flex w-full max-w-2xl overflow-hidden">
        <!-- Left Section -->
        <div class="w-1/2 p-10 flex flex-col justify-center items-center text-white text-center bg-gradient-to-r from-gray-900 to-gray-700">
            <h1 class="text-4xl font-bold">Admin Portal</h1>
            <p class="mt-5">Manage Fair Farm efficiently and securely.</p>
            <p class="mt-5 text-sm italic opacity-90">"Ensuring a seamless marketplace for farmers and buyers."</p>
        </div>

        <!-- Right Section - OTP Verification Form -->
        <div class="w-1/2 p-10">
            <h2 class="text-3xl font-bold mb-6 text-gray-700 text-center">OTP Verification</h2>
            <form method="POST" action="{{ route('admin.otp.verify.submit') }}" class="form-container mt-8">
                @csrf
                <div class="mb-4">
                    <input type="text" name="otp" id="otp" placeholder="Enter OTP" class="block w-full p-3 border rounded-lg mb-4 focus:outline-gray-600" required>
                </div>
                <div class="text-center pt-6 px-10">
                    <button type="submit" class="w-full bg-gray-700 text-white py-3 rounded-lg hover:bg-gray-800 transition">Verify OTP</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>