<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Login | Fair Farm</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto+Slab:wght@400;600&display=swap');
        
        body {
            font-family: "Roboto Slab", serif;
        }
        h1, h2 {
            font-family: "Playfair Display", serif;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body class="bg-cover bg-center min-h-screen flex justify-center items-center px-4" style="background-image: url('{{ asset('images/BuyerLoginBG.jpg') }}');">
    <div class="bg-white shadow-lg rounded-2xl flex w-full max-w-4xl h-[430px] overflow-hidden">
        <!-- Left Section (Hidden on small screens) -->
        <div class="w-1/2 p-10 flex flex-col justify-center items-center text-white text-center bg-gradient-to-r from-green-900 to-green-700 hidden md:flex">
            <h1 class="text-4xl font-bold">Welcome to Fair Farm</h1>
            <p class="mt-5">Buy high-quality paddy directly from trusted farmers.</p>
            <p class="mt-5 text-sm italic opacity-90">"Connecting farmers and buyers for a fair and transparent marketplace."</p>
        </div>

        <!-- Right Section - Login Form -->
        <div class="w-full md:w-1/2 p-6 md:p-10 items-center justify-center">
            <h2 class="text-3xl font-bold mb-6 text-green-700 text-center">Login</h2>
            <form method="POST" action="{{ route('buyer.login') }}" class="space-y-6" onsubmit="return validateForm()">
                @csrf
                <div>
                    <input type="email" name="Email" id="email" placeholder="Email" class="block w-full p-3 border-2 rounded-lg focus:outline-green-600" required>
                    <div id="emailError" class="error-message"></div>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" class="block w-full p-3 border-2 rounded-lg focus:outline-green-600" required />
                    <div id="passwordError" class="error-message"></div>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility()">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                </div>
                <div class="text-center pt-4 px-10">
                    <button type="submit" class="w-full bg-green-700 text-white py-3 rounded-lg hover:bg-green-800 transition">Login</button>
                </div>
            </form>

            <!-- Error Message Display -->
            @if(session('error'))
                <p class="text-red-500 text-center mt-4">{{ session('error') }}</p>
            @endif

            <!-- Forgot Password Link -->
            <p class="text-sm text-center mt-5">
                <a href="{{ route('buyer.password.request') }}" class="text-green-700 font-bold hover:text-green-800">Forgot Password?</a>
            </p>

            <!-- Sign Up Link -->
            <p class="text-sm text-center mt-5">New to Fair Farm? <a href="{{ route('buyer.register') }}" class="text-green-700 font-bold hover:text-green-800">Sign Up</a></p>
        </div>
    </div>

    <!-- JavaScript for Password Visibility Toggle and Validation -->
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

        // Validate Email
        function validateEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        // Validate Password (just check it's not empty for login)
        function validatePassword(password) {
            return password.length > 0;
        }

        // Form validation
        function validateForm() {
            let isValid = true;
            
            // Email validation
            const email = document.getElementById('email').value.trim();
            const emailError = document.getElementById('emailError');
            if (!validateEmail(email)) {
                emailError.textContent = 'Please enter a valid email address';
                isValid = false;
            } else {
                emailError.textContent = '';
            }
            
            // Password validation
            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('passwordError');
            if (!validatePassword(password)) {
                passwordError.textContent = 'Please enter your password';
                isValid = false;
            } else {
                passwordError.textContent = '';
            }
            
            return isValid;
        }

        // Add event listeners for real-time validation
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value.trim();
            const emailError = document.getElementById('emailError');
            if (!validateEmail(email)) {
                emailError.textContent = 'Please enter a valid email address';
            } else {
                emailError.textContent = '';
            }
        });

        document.getElementById('password').addEventListener('blur', function() {
            const password = this.value;
            const passwordError = document.getElementById('passwordError');
            if (!validatePassword(password)) {
                passwordError.textContent = 'Please enter your password';
            } else {
                passwordError.textContent = '';
            }
        });
    </script>
</body>
</html>