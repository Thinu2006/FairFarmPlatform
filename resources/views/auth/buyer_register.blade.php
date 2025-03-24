<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Sign Up</title>
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
<body class="bg-cover bg-center min-h-screen flex justify-center items-center px-4" style="background-image: url('{{ asset('images/BuyerLoginBG.jpg') }}');">  

    <div class="bg-white shadow-lg rounded-lg flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
        <!-- Left Section -->
        <div class="hidden md:flex w-full md:w-1/2 p-10 flex-col justify-center items-center text-white text-center bg-gradient-to-r from-green-900 to-green-700">
            <h1 class="text-4xl font-bold">Join Fair Farm</h1>
            <p class="mt-5">Sign up now and start buying high-quality paddy directly from trusted farmers.</p>
            <p class="mt-5 text-sm italic opacity-90">"Connecting farmers and buyers for a fair and transparent marketplace."</p>
        </div>

        <!-- Right Section -->
        <div class="w-full md:w-1/2 p-10">
            <h2 class="text-3xl font-bold mb-6 text-green-700 text-center">Create Account</h2>

            <form method="POST" action="{{ route('buyer.register') }}" class="space-y-3">
                @csrf
                <input type="text" name="FullName" placeholder="Full Name" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                @error('FullName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input type="text" name="NIC" placeholder="NIC" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                @error('NIC') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input type="text" name="ContactNo" placeholder="Contact Number" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                @error('ContactNo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input type="text" name="Address" placeholder="Address" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                @error('Address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input type="email" name="Email" placeholder="Email" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                @error('Email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <!-- Password Input with Toggle -->
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility()">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                </div>
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <div class="text-center px-10">
                    <button type="submit" class="w-full bg-green-700 text-white py-3 mt-4 rounded-lg hover:bg-green-800 transition">Register as Buyer</button>
                </div>
            </form>
            <p class="text-sm text-center mt-5">Already have an account? <a href="{{ url('buyer/login') }}" class="text-green-700 font-bold hover:text-green-800">Sign In</a></p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>
</html>