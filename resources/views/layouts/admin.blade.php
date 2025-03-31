<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles */
        body {
            font-family: 'Open Sans', sans-serif;
        }
        
        h1 {
            font-family: 'Merriweather', serif;
        }
        
        /* Mobile navigation */
        @media (max-width: 767px) {
            body {
                padding-top: 90px;
            }
            
            #mobile-nav {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0);
            }
            
            #mobile-nav.open {
                max-height: 100vh;
            }
        }

        /* Active link styling */
        .active-nav-link {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Sidebar animation */
        .nav-item {
            transition: all 0.2s ease;
        }
        
        .nav-item:hover {
            transform: translateX(4px);
        }

        /* Modal transition */
        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Mobile Header -->
    <header class="md:hidden bg-[#1F4529] text-white p-4 fixed top-0 left-0 right-0 z-40 flex justify-between items-center shadow-lg">
        <div class="flex items-center space-x-2">
            <img src="../../Images/Logo.png" alt="Logo" class="h-8">
        </div>
        <button id="mobile-menu-button" class="text-white p-2 rounded-lg focus:outline-none" aria-expanded="false">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </header>

    <!-- Mobile Navigation -->
    <nav id="mobile-nav" class="md:hidden fixed top-16 left-0 right-0 bg-[#1F4529] text-white z-30">
        <div class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.dashboard')) active-nav-link @endif">
                <i class="fas fa-home text-white w-5 text-center"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.farmer.index') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.farmer.index')) active-nav-link @endif">
                <i class="fas fa-tractor text-white w-5 text-center"></i>
                <span>Farmers</span>
            </a>
            <a href="{{ route('admin.buyer.index') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.buyer.index')) active-nav-link @endif">
                <i class="fas fa-shopping-cart text-white w-5 text-center"></i>
                <span>Customers</span>
            </a>
            <a href="{{ route('admin.paddy.index') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.paddy.index')) active-nav-link @endif">
                <i class="fas fa-seedling text-white w-5 text-center"></i>
                <span>Paddy Types</span>
            </a>
            <a href="{{ route('admin.farmer.paddy.selections') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.farmer.paddy.selections')) active-nav-link @endif">
                <i class="fas fa-list-check text-white w-5 text-center"></i>
                <span>Farmer Selections</span>
            </a>
            <a href="{{ url('admin/orders') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->is('admin/orders*')) active-nav-link @endif">
                <i class="fas fa-box text-white w-5 text-center"></i>
                <span>Orders</span>
            </a>
            <button onclick="showLogoutModal()" class="w-full flex items-center space-x-3 p-3 rounded-lg transition-colors hover:bg-green-800 pt-2 border-t border-green-700 mt-2">
                <i class="fas fa-sign-out-alt text-white w-5 text-center"></i>
                <span>Logout</span>
            </button>
        </div>
    </nav>

    <!-- Desktop Sidebar -->
    <aside class="hidden md:block w-64 bg-[#1F4529] text-white min-h-screen p-5 fixed top-0 left-0 z-30 shadow-xl">
        <div class="flex items-center space-x-3 mb-8">
            <img src="../../Images/Logo.png" alt="Logo" class="h-14">
        </div>
        <nav class="space-y-6">
            <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.dashboard')) active-nav-link @endif">
                <i class="fas fa-home text-white w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.farmer.index') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg  @if(request()->routeIs('admin.farmer.index')) active-nav-link @endif">
                <i class="fas fa-tractor text-white w-5"></i>
                <span>Farmers</span>
            </a>
            <a href="{{ route('admin.buyer.index') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.buyer.index')) active-nav-link @endif">
                <i class="fas fa-shopping-cart text-white w-5"></i>
                <span>Customers</span>
            </a>
            <a href="{{ route('admin.paddy.index') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.paddy.index')) active-nav-link @endif">
                <i class="fas fa-seedling text-white w-5"></i>
                <span>Paddy Types</span>
            </a>
            <a href="{{ route('admin.farmer.paddy.selections') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('admin.farmer.paddy.selections')) active-nav-link @endif">
                <i class="fas fa-list-check text-white w-5"></i>
                <span>Farmer Selections</span>
            </a>
            <a href="{{ url('admin/orders') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->is('admin/orders*')) active-nav-link @endif">
                <i class="fas fa-box text-white w-5"></i>
                <span>Orders</span>
            </a>
            <button onclick="showLogoutModal()" class="nav-item w-full flex items-center space-x-3 p-3 rounded-lg transition-colors hover:bg-green-800 pt-4 mt-4 border-t border-green-700">
                <i class="fas fa-sign-out-alt text-white w-5"></i>
                <span>Logout</span>
            </button>
        </nav>
    </aside>

    <!-- Main Content Section -->
    <main class="flex-1 md:ml-64 min-h-screen bg-gray-50">
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 invisible transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-md transform transition-all scale-95">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Logout</h3>
                <p class="text-gray-500 mb-6">Are you sure you want to logout from the admin panel?</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideLogoutModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        Cancel
                    </button>
                    <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle with animation
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileNav = document.getElementById('mobile-nav');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            mobileNav.classList.toggle('open');
            this.setAttribute('aria-expanded', !isExpanded);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Logout modal functions
        function showLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('opacity-0', 'invisible', 'scale-95');
            modal.classList.add('opacity-100', 'visible', 'scale-100');
        }

        function hideLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('opacity-100', 'visible', 'scale-100');
            modal.classList.add('opacity-0', 'invisible', 'scale-95');
        }

        // Close modal when clicking outside
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideLogoutModal();
            }
        });
    </script>
</body>
</html>