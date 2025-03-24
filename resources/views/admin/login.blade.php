<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Ensure the background image covers the entire screen and is centered */
        body {
            background-image: url('{{ asset('images/AdminLoginBG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        body {
            background-image: url('{{ asset('images/AdminLoginBG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <!-- Login Container -->
<<<<<<< HEAD
    <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden min-h-[400px]"> 
        <!-- Left Section (Image or Branding) -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white hidden md:flex w-full md:w-1/2 p-10 flex-col justify-center items-center text-center ">
=======
    <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden min-h-[500px]"> 
        <!-- Left Section (Image or Branding) -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white p-10 flex flex-col justify-center items-center text-center md:w-1/2">
>>>>>>> 50309ae95b6ee917179061e0b2d7e07e2f7f4aec
            <h1 class="text-4xl font-bold mb-4">Admin Portal</h1>
            <p class="text-lg mb-2">Manage Fair Farm efficiently and securely.</p>
            <p class="text-sm italic opacity-90">"Ensuring a seamless marketplace for farmers and buyers."</p>
        </div>

        <!-- Right Section (Login Form) -->
<<<<<<< HEAD
        <div class="w-full md:w-1/2 p-6 md:p-12 items-center justify-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 text-center">Login</h2>
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-10">
                @csrf
                <!-- Email Input -->
                <input type="email" name="Email"id="Email" placeholder="Email" class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all" required />

                <!-- Password Input with Toggle -->
                <div class="relative mt-8">
                    <input type="password" name="Password" id="Password" placeholder="Password" class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all " required/>
                    <span class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                </div>

                <div class="text-center px-20 ">
                    <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-900 transition-all focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2">
                        Sign In
                    </button>
=======
        <div class="p-12 md:w-1/2 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Login</h2>
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                @csrf
                <!-- Email Input -->
                <div class="relative">
                    <input
                        type="email"
                        name="Email"
                        id="Email"
                        placeholder="Email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all"
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent transition-all pr-12"
                        required
                    />
                    <!-- Eye Icon for Password Toggle -->
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
                        <svg
                            id="eye-icon"
                            class="h-6 w-6 text-gray-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            ></path>
                        </svg>
                    </span>
>>>>>>> 50309ae95b6ee917179061e0b2d7e07e2f7f4aec
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-900 transition-all focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2">
                    Sign In
                </button>
            </form>
            
            <!-- Error Message Display -->
            @if(session('error'))
                <p class="text-red-500 text-center mt-4">{{ session('error') }}</p>
            @endif

            <!-- Forgot Password Link -->
            <!-- <p class="text-sm text-center mt-5">
                <a href="{{ route('buyer.password.request') }}" class="text-gray-900 font-bold hover:text-gray-600">Forgot Password?</a>
            </p> -->


        </div>
    </div>

    <!-- JavaScript for Password Visibility Toggle -->
<<<<<<< HEAD

=======
>>>>>>> 50309ae95b6ee917179061e0b2d7e07e2f7f4aec
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('Password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
<<<<<<< HEAD
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
=======
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.048 0 2.062.18 3 .512v1.682a7.047 7.047 0 00-3-.594c-3.866 0-7 3.134-7 7s3.134 7 7 7a7.047 7.047 0 003-.594v1.682zM15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
>>>>>>> 50309ae95b6ee917179061e0b2d7e07e2f7f4aec
            }
        }
    </script>
</body>
</html>