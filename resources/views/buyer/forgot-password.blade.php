<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Fair Farm</title>
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
    </style>
</head>
<body class="bg-cover bg-center min-h-screen flex justify-center items-center px-4" style="background-image: url('{{ asset('images/BuyerLoginBG.jpg') }}');">
    <div class="bg-white shadow-lg rounded-2xl flex w-full max-w-4xl h-[350px] overflow-hidden">
        <!-- Left Section -->
        <div class="w-1/2 p-10 flex flex-col justify-center items-center text-white text-center bg-gradient-to-r from-green-900 to-green-700 hidden md:flex">
            <h1 class="text-4xl font-bold">Forgot Password</h1>
            <p class="mt-5">Enter your email address to reset your password.</p>
        </div>

        <!-- Right Section - Forgot Password Form -->
        <div class="w-full md:w-1/2 p-6 md:p-10 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto"> 
                <h2 class="text-3xl font-bold mb-12 text-green-700 text-center">Reset Password</h2>
                <form method="POST" action="{{ route('buyer.password.email') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700"></label>
                        <input type="email" name="Email" id="Email" 
                            value="{{ old('Email') }}" 
                            required 
                            autofocus
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Enter your email address">
                    </div>
                    <div class="pt-4 px-12">
                        <button type="submit" class="w-full flex justify-center py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>    

            <!-- Status Message -->
            @if (session('status'))
                <p class="text-green-500 text-center mt-4">{{ session('status') }}</p>
            @endif

            <!-- Error Message Display -->
            @if ($errors->any())
                <div class="text-red-500 text-center mt-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <p class="text-sm text-center mt-5">
                Remember your password? 
                <a href="{{ route('buyer.login') }}" class="text-green-700 font-bold hover:text-green-800">Login</a>
            </p>
        </div>
    </div>
</body>
</html>