<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('images/AdminLoginBG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 sm:p-6">
    <!-- Login Container -->
    <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden min-h-[400px] md:min-h-[500px]"> 
        <!-- Left Section (Image or Branding) -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white p-8 md:p-10 flex flex-col justify-center items-center text-center md:w-1/2">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 md:mb-4">Admin Portal</h1>
            <p class="text-base md:text-lg mb-2">Manage Fair Farm efficiently and securely.</p>
            <p class="text-xs md:text-sm italic opacity-90">"Ensuring a seamless marketplace for farmers and buyers."</p>
        </div>

        <!-- Right Section (Login Form) -->
        <!-- Right Section (Login Form) -->
        <div class="w-full p-6 md:p-8 lg:p-12 flex flex-col justify-center md:w-1/2">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8 text-center">Login</h2>
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-4 md:space-y-6">
                @csrf
                <!-- Email Input -->
                <div class="relative">
                    <input
                        type="email"
                        name="Email"
                        id="Email"
                        placeholder="Email"
                        class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all"
                        required
                    />
                </div>

                <!-- Password Input with Toggle -->
                <div class="relative">
                    <input
                        type="password"
                        name="Password"
                        id="Password"
                        placeholder="Password"
                        class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all pr-12"
                        required
                    />
                    <!-- Eye Icon for Password Toggle -->
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
                        <i id="eye-icon" class="far fa-eye text-gray-500"></i>
                    </span>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        class="h-4 w-4 text-gray-800 focus:ring-gray-700 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-gray-800 text-white py-2 md:py-3 rounded-lg hover:bg-gray-900 transition-all focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2">
                    Sign In
                </button>
            </form>
            
            <!-- Error Message Display -->
            @if(session('error'))
                <p class="text-red-500 text-center mt-3 md:mt-4">{{ session('error') }}</p>
            @endif
        </div>
    </div>

    <!-- JavaScript for Password Visibility Toggle -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('Password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>