<nav class="bg-white border-b border-gray-100 py-3 px-6 md:px-10 flex items-center justify-between sticky top-0 z-50">
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
            @auth('buyer')
            <form action="{{ route('buyer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-red-600 transition-colors duration-300 px-4 py-2 font-medium">
                    Logout
                </button>
            </form>
            @endauth
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
                <a href="" class="block py-2 text-gray-700 hover:text-[#1F4529] transition-colors duration-300 font-medium">
                    My Orders
                </a>
            </li>
            <li class="pt-4 border-t border-gray-100">
                <a href="#" class="block py-2 text-gray-700 hover:text-[#1F4529] transition-colors duration-300 font-medium">
                    Contact Us
                </a>
            </li>
            @auth('buyer')
            <li>
                <form action="{{ route('buyer.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block py-2 text-gray-700 hover:text-red-600 transition-colors duration-300 font-medium w-full text-left">
                        Logout
                    </button>
                </form>
            </li>
            @endauth
        </ul>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        
        // Change icon to X when menu is open
        const icon = this.querySelector('svg');
        if (menu.classList.contains('hidden')) {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
        } else {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        }
    });
</script>