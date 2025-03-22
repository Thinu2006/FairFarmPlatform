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
<body class="bg-cover bg-center min-h-screen flex justify-center items-center px-4" 
      style="background-image: url('./../../Images/bg.jpg');">

    <div class="bg-white shadow-lg rounded-lg flex w-full max-w-4xl overflow-hidden">
        <!-- Left Section - Welcome Message -->
        <div class="w-1/2 p-10 flex flex-col justify-center items-center text-white text-center bg-gradient-to-r from-green-900 to-green-700">
            <h1 class="text-4xl font-bold">Join Fair Farm</h1>
            <p class="mt-5">Sign up now and start buying high-quality paddy directly from trusted farmers.</p>
            <p class="mt-5 text-sm italic opacity-90">"Connecting farmers and buyers for a fair and transparent marketplace."</p>
        </div>

        <!-- Right Section - Signup Form -->
        <div class="w-1/2 p-10">
            <h2 class="text-3xl font-bold mb-6 text-green-700 text-center">Create Account</h2>

            <form method="POST" action="{{ route('buyer.register') }}" class="space-y-3">
                @csrf
                <input type="text" name="FullName" placeholder="Full Name" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                <input type="text" name="NIC" placeholder="NIC" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                <input type="text" name="ContactNo" placeholder="Contact Number" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                <input type="text" name="Address" placeholder="Address" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                <input type="email" name="Email" placeholder="Email" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />
                <input type="password" name="password" placeholder="Password" class="block w-full p-2 border rounded-lg focus:outline-green-600" required />

                <div class="flex items-center text-sm mt-4">
                    <input type="checkbox" class="mr-2" required>
                    <span>I agree to the <a href="./terms&condition.php" class="text-green-700 font-bold hover:text-green-800">terms & conditions</a></span>
                </div>

                <div class="text-center px-10">
                    <button type="submit" class="w-full bg-green-700 text-white py-3 mt-4 rounded-lg hover:bg-green-800 transition">Register as Buyer</button>
                </div>
            </form>
            <p class="text-sm text-center mt-5">Already have an account? <a href="{{ url('buyer/login') }}" class="text-green-700 font-bold hover:text-green-800">Sign In</a></p>
        </div>
    </div>
</body>
</html>
