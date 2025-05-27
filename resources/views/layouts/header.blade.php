<nav class="bg-white border-b border-gray-100 py-3 px-6 md:px-10 flex items-center justify-between sticky top-0 z-50 font-slab text-lg font-bold">
    <!-- Logo -->
    <div class="flex items-center">
        <a href="{{ route('buyer.dashboard') }}" class="flex items-center group">
            <img src="{{ asset('images/lg2.png') }}" alt="Fair Farm Logo" class="h-9 md:h-10 transition-opacity duration-300 group-hover:opacity-90">
        </a>
    </div>
    
    <!-- Desktop Navigation -->
    <div class="hidden md:flex items-center space-x-8">
        <ul class="flex space-x-8">
            <li>
                <a href="{{ route('buyer.dashboard') }}" class="text-gray-700 hover:text-[#2f613c] font-medium transition-colors duration-300 relative py-2">
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-px bg-[#1F4529] transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('buyer.products') }}" class="text-gray-700 hover:text-[#2f613c] font-medium transition-colors duration-300 relative py-2">
                    Our Products
                    <span class="absolute bottom-0 left-0 w-0 h-px bg-[#1F4529] transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('buyer.orders') }}" class="text-gray-700 hover:text-[#2f613c] font-medium transition-colors duration-300 relative py-2">
                    My Orders
                    <span class="absolute bottom-0 left-0 w-0 h-px bg-[#1F4529] transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
        </ul>
        
        <div class="flex items-center space-x-4 ml-6">
            <a href="#" class="text-gray-700 hover:text-[#2f613c] transition-colors duration-300 px-4 py-2 font-medium">
                Contact
            </a>
            
            <!-- Account Dropdown -->
            <div class="relative group">
                <button class="flex items-center text-gray-700 hover:text-[#2f613c] transition-colors duration-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </button>
                <div class="absolute right-0 w-[180px] bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                    <a href="{{ route('buyer.account') }}" class="block px-4 py-2 font-medium text-gray-700 hover:bg-gray-100">Account Settings</a>
                    <button onclick="showLogoutConfirmation()" class="block w-full text-left px-4 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-red-600">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu Button -->
    <button id="mobile-menu-button" class="md:hidden text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden absolute top-16 left-0 right-0 bg-white shadow-lg border-t border-gray-100 py-4 px-6">
        <ul class="space-y-4">
            <li>
                <a href="{{ route('buyer.dashboard') }}" class="block py-2 text-gray-700 hover:text-[#1F4529] transition-colors duration-300 font-medium">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('buyer.products') }}" class="block py-2 text-gray-700 hover:text-[#1F4529] transition-colors duration-300 font-medium">
                    Our Products
                </a>
            </li>
            <li>
                <a href="{{ route('buyer.orders') }}" class="block py-2 text-gray-700 hover:text-[#1F4529] transition-colors duration-300 font-medium">
                    My Orders
                </a>
            </li>
            <li>
                <a href="{{ route('buyer.account') }}" class="block py-2 text-gray-700 hover:text-[#1F4529] transition-colors duration-300 font-medium">
                    Account Settings
                </a>
            </li>
            <li class="pt-4 border-t border-gray-100">
                <a href="#" class="block py-2 text-gray-700 hover:text-[#1F4529] transition-colors duration-300 font-medium">
                    Contact Us
                </a>
            </li>
            @auth('buyer')
            <li>
                <button onclick="showLogoutConfirmation()" class="block py-2 text-gray-700 hover:text-red-600 transition-colors duration-300 font-medium w-full text-left">
                    Logout
                </button>
            </li>
            @endauth
        </ul>
    </div>
</nav>
<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Logout</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to logout?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="hideLogoutConfirmation()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                Cancel
            </button>
            <form id="logoutForm" action="{{ route('buyer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    function showLogoutConfirmation() {
        document.getElementById('logoutModal').classList.remove('hidden');
    }
    
    function hideLogoutConfirmation() {
        document.getElementById('logoutModal').classList.add('hidden');
    }
</script>