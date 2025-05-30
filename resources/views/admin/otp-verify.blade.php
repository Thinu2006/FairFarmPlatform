<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification | Fair Farm</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto+Slab:wght@400;600&display=swap');
        
        body {
            font-family: "Roboto Slab", serif;
        }
        h1, h2 {
            font-family: "Playfair Display", serif;
        }
        .otp-input-container {
            position: relative;
        }
        .toggle-otp-visibility {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }
    </style>
</head>

<body class="bg-cover bg-center min-h-screen flex justify-center items-center px-4" style="background-image: url('{{ asset('images/AdminLoginBG.jpg') }}');">
    <div class="bg-white shadow-lg rounded-2xl flex w-full max-w-4xl h-[430px] overflow-hidden">
        <!-- Left Section -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white p-8 md:p-10 flex flex-col justify-center items-center text-center md:w-1/2">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 md:mb-4">Admin Portal</h1>
            <p class="text-base md:text-lg mb-2">Manage Fair Farm efficiently and securely.</p>
            <p class="text-xs md:text-sm italic opacity-90">"Ensuring a seamless marketplace for farmers and buyers."</p>
        </div>

        <!-- Right Section - OTP Verification Form -->
        <div class="w-full md:w-1/2 p-6 md:p-10 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto"> 
                <h2 class="text-3xl font-bold mb-12 text-gray-700 text-center">OTP Verification</h2>
                <form method="POST" action="{{ route('admin.otp.verify.submit') }}" class="space-y-8">
                    @csrf
                    <div class="otp-input-container">
                        <input type="password" name="otp" id="otp" placeholder="Enter OTP" class="block w-full p-3 border-2 rounded-lg focus:outline-gray-600 pr-10" required>
                        <i class="toggle-otp-visibility fas fa-eye" id="toggleOtpVisibility"></i>
                    </div>
                    <div class="pt-4 px-12">
                        <button type="submit" class="w-full bg-gray-700 text-white py-3 rounded-lg hover:bg-gray-800 transition">Verify OTP</button>
                    </div>
                </form>

                <!-- Error Message Display -->
                @if(session('error'))
                    <p class="text-red-500 text-center mt-4">{{ session('error') }}</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleOtpVisibility = document.getElementById('toggleOtpVisibility');
            const otpInput = document.getElementById('otp');
            
            toggleOtpVisibility.addEventListener('click', function() {
                if (otpInput.type === 'password') {
                    otpInput.type = 'text';
                    toggleOtpVisibility.classList.remove('fa-eye');
                    toggleOtpVisibility.classList.add('fa-eye-slash');
                } else {
                    otpInput.type = 'password';
                    toggleOtpVisibility.classList.remove('fa-eye-slash');
                    toggleOtpVisibility.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>