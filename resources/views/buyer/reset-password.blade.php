<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Fair Farm</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Font Awesome for eye icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto+Slab:wght@400;600&display=swap');
        
        body {
            font-family: "Roboto Slab", serif;
        }
        h1, h2 {
            font-family: "Playfair Display", serif;
        }
        /* Add styles for password toggle */
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }
        .toggle-password:hover {
            color: #4b5563;
        }
    </style>
</head>
<body class="bg-cover bg-center min-h-screen flex justify-center items-center px-4" style="background-image: url('{{ asset('images/BuyerLoginBG.jpg') }}');">
    <div class="bg-white shadow-lg rounded-2xl flex w-full max-w-4xl h-[400px] overflow-hidden">
        <!-- Left Section -->
        <div class="w-1/2 p-10 flex flex-col justify-center items-center text-white text-center bg-gradient-to-r from-green-900 to-green-700 hidden md:flex">
            <h1 class="text-4xl font-bold">Reset Password</h1>
            <p class="mt-5">Enter your new password to reset your account.</p>
        </div>

        <!-- Right Section - Reset Password Form -->
        <div class="w-full md:w-1/2 p-6 md:p-10 items-center justify-center">
            <div class="max-w-md w-full mx-auto"> 
                <h2 class="text-3xl font-bold mb-12 text-green-700 text-center">Reset Password</h2>
                <form method="POST" action="{{ route('buyer.password.update') }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="Email" value="{{ $Email }}">

                    <div class="password-container">
                        <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Enter your new password">
                        <i class="toggle-password fas fa-eye" data-target="password"></i>
                    </div>

                    <div class="password-container">
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Confirm your new password">
                        <i class="toggle-password fas fa-eye" data-target="password_confirmation"></i>
                    </div>

                    <div class="pt-4 px-12">
                        <button type="submit" class="w-full flex justify-center py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Error Message Display -->
            @if ($errors->any())
                <div class="text-red-500 text-center mt-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Add JavaScript for toggle functionality -->
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>