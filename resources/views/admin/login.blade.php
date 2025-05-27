<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto+Slab:wght@400;600&display=swap');

        body {
            background-image: url('{{ asset('images/AdminLoginBG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;

            font-family: "Roboto Slab", serif;
            font-size: 16px;
        }

        h1, h2 {
            font-family: "Playfair Display", serif;
        }
    </style>

</head>
<body class="flex items-center justify-center p-4 sm:p-6">
    <!-- Back Button (Top Left) -->
    <a href="{{ url('/') }}" class="absolute top-4 left-4 bg-white/80 hover:bg-white text-black font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Welcome
    </a>
    <!-- Login Container -->
    <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden min-h-[350px] md:min-h-[300px]"> 
        <!-- Left Section (Image or Branding) - Hidden on small screens -->
        <div class="hidden md:flex bg-gradient-to-r from-gray-900 to-gray-700 text-white p-8 md:p-10 flex-col justify-center items-center text-center md:w-1/2">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 md:mb-4">Admin Portal</h1>
            <p class="text-base md:text-lg mb-2">Manage Fair Farm efficiently and securely.</p>
            <p class="text-xs md:text-sm italic opacity-90">"Ensuring a seamless marketplace for farmers and buyers."</p>
        </div>

        <!-- Right Section (Login Form) - Full width on small screens -->
        <div class="w-full p-6 md:p-8 lg:p-12 flex flex-col justify-between md:w-1/2">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8 mt-4 md:mt-0 text-center">Login</h2>
                <form method="POST" action="{{ route('admin.login') }}" class="space-y-8 md:space-y-8" id="loginForm" novalidate>
                    @csrf
                    <!-- Email Input -->
                    <div>
                        <div class="relative">
                            <input type="email" name="Email" id="Email" placeholder="Email"class="w-full px-4 py-2 md:py-3 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all" required autocomplete="email"/>
                        </div>
                        <div id="email-error" class="error-message hidden">Please enter a valid email address</div>
                    </div>

                    <!-- Password Input with Toggle -->
                    <div>
                        <div class="relative">
                            <input
                                type="password"
                                name="Password"
                                id="Password"
                                placeholder="Password"
                                class="w-full px-4 py-2 md:py-3 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all pr-12"
                                required
                                minlength="8"
                                autocomplete="current-password"
                            />
                            <!-- Eye Icon for Password Toggle -->
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
                                <i id="eye-icon" class="far fa-eye text-gray-500"></i>
                            </span>
                        </div>
                        <div id="password-error" class="error-message hidden text-sm">Password must be at least 8 characters</div>
                    </div>
                </form>
                
                <!-- Error Message Display -->
                @if(session('error'))
                    <p class="text-red-500 text-center mt-3 md:mt-4">{{ session('error') }}</p>
                @endif
            </div>

            <!-- Login Button - Fixed to bottom -->
            <div class="pt-8 md:pt-10 px-20">
                <button type="submit" form="loginForm" class=" w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-gray-900 transition text-lg">
                    Sign In
                </button>
            </div>
           
        </div>
    </div>

    <!-- JavaScript for Password Visibility Toggle and Validation -->
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

        // Form Validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('Email');
            const passwordInput = document.getElementById('Password');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');

            // Validate on form submission
            form.addEventListener('submit', function(event) {
                let isValid = true;
                
                // Reset previous errors
                emailError.classList.add('hidden');
                passwordError.classList.add('hidden');
                emailInput.classList.remove('input-error');
                passwordInput.classList.remove('input-error');

                // Email validation
                if (!emailInput.value) {
                    emailError.textContent = 'Email is required';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('input-error');
                    isValid = false;
                } else if (!isValidEmail(emailInput.value)) {
                    emailError.textContent = 'Please enter a valid email address';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('input-error');
                    isValid = false;
                }

                // Password validation
                if (!passwordInput.value) {
                    passwordError.textContent = 'Password is required';
                    passwordError.classList.remove('hidden');
                    passwordInput.classList.add('input-error');
                    isValid = false;
                } else if (passwordInput.value.length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters';
                    passwordError.classList.remove('hidden');
                    passwordInput.classList.add('input-error');
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });

            // Real-time validation for email
            emailInput.addEventListener('input', function() {
                if (!isValidEmail(emailInput.value)) {
                    emailError.textContent = 'Please enter a valid email address';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('input-error');
                } else {
                    emailError.classList.add('hidden');
                    emailInput.classList.remove('input-error');
                }
            });

            // Real-time validation for password
            passwordInput.addEventListener('input', function() {
                if (passwordInput.value.length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters';
                    passwordError.classList.remove('hidden');
                    passwordInput.classList.add('input-error');
                } else {
                    passwordError.classList.add('hidden');
                    passwordInput.classList.remove('input-error');
                }
            });

            // Helper function to validate email
            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
</body>
</html>