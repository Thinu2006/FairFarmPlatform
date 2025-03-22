<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="fixed inset-0 flex z-10">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-[#1F4529] text-white min-h-screen p-5 fixed top-0 left-0">
            <div class="flex items-center space-x-2 mb-8">
                <img src="../../Images/Logo.png" alt="Logo" class="h-14">
            </div>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 p-3 hover:bg-green-800 rounded-lg">
                    <i class="fas fa-home text-white"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.farmer.index') }}" class="flex items-center space-x-2 p-3 hover:bg-green-800 rounded-lg">
                    <i class="fas fa-tractor text-white"></i>
                    <span>Farmers</span>
                </a>
                <a href="{{ route('admin.buyer.index') }}" class="flex items-center space-x-2 p-3 hover:bg-green-800 rounded-lg">
                    <i class="fas fa-shopping-cart text-white"></i>
                    <span>Customers</span>
                </a>
                <a href="{{ route('admin.paddy.index') }}" class="flex items-center space-x-2 p-3 hover:bg-green-800 rounded-lg">
                    <i class="fas fa-seedling text-white"></i>
                    <span>Paddy Types</span>
                </a>

                <a href="{{ url('admin/orders') }}" class="flex items-center space-x-2 p-3 hover:bg-green-800 rounded-lg">
                    <i class="fas fa-box text-white"></i>
                    <span>Orders</span>
                </a>

                <!-- Logout -->
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-8">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 p-3 hover:bg-green-800 rounded-lg w-full">
                        <i class="fas fa-sign-out-alt text-white"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content Section -->
        <div class="flex-1 ml-64 p-10">
            @yield('content')
        </div>

    </div>
</body>
</html>
