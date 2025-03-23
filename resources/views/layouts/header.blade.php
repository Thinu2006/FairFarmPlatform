<nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center sticky top-0 z-50">
    <img src="{{ asset('images/lg2.png') }}" alt="FarmLanka Logo" class="h-12">
    <ul class="flex space-x-6 text-gray-700">
        <li><a href="{{ route('buyer.dashboard') }}" class="hover:text-green-600 transition duration-300">Home</a></li>
        <li><a href="{{route('buyer.products')}}" class="hover:text-green-600 transition duration-300">Our Product</a></li>
        <li><a href="" class="hover:text-green-600 transition duration-300">My Orders</a></li>
    </ul>
    <div class="flex items-center space-x-4">
        <button class="bg-[#1F4529] text-white px-4 py-2 rounded-md hover:bg-green-800 transition duration-300">
            <a href="">Contact Us</a>
        </button>
        @auth('buyer')
            <form action="{{ route('buyer.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300">
                    Logout
                </button>
            </form>
        @endauth
    </div>
</nav>