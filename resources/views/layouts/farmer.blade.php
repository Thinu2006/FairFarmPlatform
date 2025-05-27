<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ගොවියන්ගේ උපකරණ පුවරුව')</title>
    <!-- Favicon -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <style>
        /* Custom styles */
        body {
            font-family: 'Open Sans', sans-serif;
        }
        h1,h3, h2, h5 {
            font-family: 'Merriweather', serif;
        }
        p {
            font-family: 'Roboto Slab', serif;
        }
        .font-display {
            font-family: 'Playfair Display', serif !important;
        }

        /* Mobile navigation */
        @media (max-width: 767px) {
            body {
                padding-top: 80px;
            }

            #mobile-nav {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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

        /* Modal styles */
        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-content {
            transition: transform 0.3s ease;
        }

        .modal-hidden {
            opacity: 0;
            visibility: hidden;
        }

        .modal-visible {
            opacity: 1;
            visibility: visible;
        }

        .modal-content-hidden {
            transform: translateY(-20px);
        }

        .modal-content-visible {
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Mobile Header -->
    <header class="md:hidden bg-[#1F4529] text-white p-4 fixed top-0 left-0 right-0 z-40 flex justify-between items-center shadow-lg">
        <div class="flex items-center space-x-2">
            <img src="../../Images/Logo.png" alt="ලාංඡනය" class="h-8">
        </div>
        <button id="mobile-menu-button" class="text-white p-2 rounded-lg focus:outline-none" aria-expanded="false">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </header>

    <!-- Mobile Navigation -->
    <nav id="mobile-nav" class="md:hidden fixed top-16 left-0 right-0 bg-[#1F4529] text-white z-30">
        <div class="p-4 space-y-2">
            <a href="{{ route('farmer.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.dashboard')) active-nav-link @endif">
                <i class="fas fa-home text-white w-5 text-center"></i>
                <span>ප්‍රධාන පුවරුව</span>
            </a>
            <a href="{{ route('farmer.paddy.listing') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.paddy.listing')) active-nav-link @endif">
                <i class="fas fa-seedling text-white w-5 text-center"></i>
                <span>වී ලැයිස්තුව</span>
            </a>
            <a href="{{ route('farmer.orders.index') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.orders.index')) active-nav-link @endif">
                <i class="fas fa-box text-white w-5 text-center"></i>
                <span>ඇණවුම්</span>
            </a>
            <a href="{{ route('farmer.account') }}" class="flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.account')) active-nav-link @endif">
                <i class="fas fa-user-cog text-white w-5 text-center"></i>
                <span>ගිණුම් සැකසුම්</span>
            </a>
            <button onclick="showLogoutModal()" class="flex items-center space-x-3 p-3 rounded-lg w-full transition-colors hover:bg-green-800">
                <i class="fas fa-sign-out-alt text-white w-5 text-center"></i>
                <span>පිටවීම</span>
            </button>
        </div>
    </nav>

    <!-- Desktop Sidebar -->
    <aside class="hidden md:block w-64 bg-[#1F4529] text-white min-h-screen p-5 fixed top-0 left-0 z-30 shadow-xl">
        <div class="flex items-center space-x-3 mb-8">
            <img src="../../Images/Logo.png" alt="ලාංඡනය" class="h-14">
        </div>
        <nav class="space-y-6">
            <a href="{{ route('farmer.dashboard') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.dashboard')) active-nav-link @endif">
                <i class="fas fa-home text-white w-5"></i>
                <span>ප්‍රධාන පුවරුව</span>
            </a>
            <a href="{{ route('farmer.paddy.listing') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.paddy.listing')) active-nav-link @endif">
                <i class="fas fa-seedling text-white w-5"></i>
                <span>වී ලැයිස්තුව</span>
            </a>
            <a href="{{ route('farmer.orders.index') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.orders.index')) active-nav-link @endif">
                <i class="fas fa-box text-white w-5"></i>
                <span>ඇණවුම්</span>
            </a>
            <a href="{{ route('farmer.account') }}" class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-colors @if(request()->routeIs('farmer.account')) active-nav-link @endif">
                <i class="fas fa-user-cog text-white w-5"></i>
                <span>ගිණුම් සැකසුම්</span>
            </a>
            <button onclick="showLogoutModal()" class="nav-item flex items-center space-x-3 p-3 rounded-lg w-full transition-colors hover:bg-green-800">
                <i class="fas fa-sign-out-alt text-white w-5"></i>
                <span>පිටවීම</span>
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
    <div id="logoutModal" class="modal fixed inset-0 flex items-center justify-center z-50 modal-hidden">
        <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>

        <div class="modal-content bg-white rounded-lg shadow-xl p-6 w-full max-w-md relative z-10 modal-content-hidden">
            <div class="text-center">
                <i class="fas fa-sign-out-alt text-4xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">පිටවීම තහවුරු කරන්න</h3>
                <p class="text-gray-600 mb-6">ඔබට ඔබගේ ගිණුමෙන් පිටවීමට අවශ්‍ය බව තහවුරු කරන්නද?</p>

                <div class="flex justify-center space-x-4">
                    <button onclick="hideLogoutModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition-colors">
                        අවලංගු කරන්න
                    </button>
                    <form action="{{ route('farmer.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                            පිටවීම
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

        // Logout Modal Functions
        function showLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const modalContent = modal.querySelector('.modal-content');

            modal.classList.remove('modal-hidden');
            modal.classList.add('modal-visible');

            setTimeout(() => {
                modalContent.classList.remove('modal-content-hidden');
                modalContent.classList.add('modal-content-visible');
            }, 10);
        }

        function hideLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const modalContent = modal.querySelector('.modal-content');

            modalContent.classList.remove('modal-content-visible');
            modalContent.classList.add('modal-content-hidden');

            setTimeout(() => {
                modal.classList.remove('modal-visible');
                modal.classList.add('modal-hidden');
            }, 300);
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function() {
                if (this.parentElement.id === 'logoutModal') {
                    hideLogoutModal();
                }
            });
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const logoutModal = document.getElementById('logoutModal');

                if (logoutModal.classList.contains('modal-visible')) {
                    hideLogoutModal();
                }
            }
        });
    </script>
</body>
</html>
