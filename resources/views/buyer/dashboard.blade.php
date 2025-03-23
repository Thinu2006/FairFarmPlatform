@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative w-full min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('images/HomepgBG.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40 flex items-center justify-center px-6 text-center">
            <h2 class="text-white text-4xl md:text-6xl font-bold hero-text">Sri Lanka Has A Long History Of Agriculture</h2>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 px-6 flex flex-col md:flex-row items-center max-w-7xl mx-auto">
        <img src="{{ asset('images/IMG4.jpg') }}" alt="Paddy" class="w-full md:w-1/3 rounded-lg shadow-lg">
        <div class="md:ml-10 mt-6 md:mt-0">
            <h3 class="text-[#1F4529] text-3xl font-semibold">Paddy Of Sri Lanka</h3>
            <p class="text-gray-800 mt-5">Sri Lanka has a deep-rooted history in agriculture, particularly in paddy cultivation. The country's fertile lands and traditional farming techniques have resulted in some of the finest rice varieties in the world.</p>
            <p class="text-gray-800 mt-2">Farmers across the island dedicate their lives to producing high-quality rice that meets both local and international demands.</p>
            <button class="mt-4 bg-[#1F4529] text-white px-6 py-2 rounded-md hover:bg-green-800 transition duration-300">Read More</button>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 px-6 bg-gray-50">
        <h3 class="text-center text-3xl font-semibold text-[#1F4529]">Our Products</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach ($sellingPaddyTypes as $paddy)
                <div class="bg-white p-6 rounded-lg shadow-md card-hover">
                    <!-- Paddy Image -->
                    <img src="{{ asset('storage/' . $paddy->paddyType->Image) }}" alt="{{ $paddy->paddyType->PaddyName }}" class="w-full h-48 object-cover rounded-md">

                    <!-- Paddy Name -->
                    <h4 class="mt-4 text-xl font-semibold">{{ $paddy->paddyType->PaddyName }}</h4>

                    <!-- Price -->
                    <p class="text-gray-800 font-bold">per 1Kg - Rs{{ $paddy->PriceSelected }}</p>

                    <!-- Farmer Details -->
                    <p class="text-gray-600 mt-2"><strong>Farmer details</strong></p>
                    <ul class="text-gray-600 text-sm">
                        <li>&bull; {{ $paddy->farmer->FullName }}</li>
                        <li>&bull; {{ $paddy->farmer->Address }}</li>
                    </ul>

                    <!-- Read More Button -->
                    <button class="mt-4 bg-[#1F4529] text-white px-4 py-2 rounded-md hover:bg-green-800 transition duration-300">
                        Read More
                    </button>
                </div>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('buyer.products') }}" class="bg-[#1F4529] text-white px-6 py-3 rounded-md hover:bg-green-800 transition duration-300">More Products</a>
        </div>
    </section>

    <!-- Quality and Pricing Section -->
    <section class="relative w-full h-64 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/paddy4.jpg') }}');">
        <div class="bg-black/50 h-full flex items-center">
            <div class="flex justify-around max-w-4xl mx-auto w-full text-white text-center">
                <div>
                    <h4 class="text-3xl font-semibold">100+</h4>
                    <p>High Quality</p>
                </div>
                <div>
                    <h4 class="text-3xl font-semibold">100+</h4>
                    <p>Fair Prices</p>
                </div>
                <div>
                    <h4 class="text-3xl font-semibold">40+</h4>
                    <p>Island Farmers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 px-6 bg-gray-50">
        <h3 class="text-center text-3xl font-semibold text-[#1F4529]">What Our Buyers Say</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto text-center">
            <!-- Testimonial 1 -->
            <div class="bg-white p-6 rounded-lg shadow-md card-hover">
                <img src="{{ asset('images/buyer1.jpg') }}" alt="Nimal Perera" class="w-16 h-16 rounded-full mx-auto">
                <h4 class="mt-4 text-xl font-semibold">Nimal Perera</h4>
                <p class="text-gray-600 mt-2">The rice was of excellent quality, delivered in good quantity, and priced fairly. Truly worth it.</p>
                <div class="mt-4 text-yellow-500">★★★★★</div>
            </div>
            <!-- Testimonial 2 -->
            <div class="bg-white p-6 rounded-lg shadow-md card-hover">
                <img src="{{ asset('images/buyer2.jpg') }}" alt="Ranoweera" class="w-16 h-16 rounded-full mx-auto">
                <h4 class="mt-4 text-xl font-semibold">Ranoweera</h4>
                <p class="text-gray-600 mt-2">Great value for money with high-quality rice, ample quantity, and a very reasonable price.</p>
                <div class="mt-4 text-yellow-500">★★★★★</div>
            </div>
            <!-- Testimonial 3 -->
            <div class="bg-white p-6 rounded-lg shadow-md card-hover">
                <img src="{{ asset('images/buyer3.jpg') }}" alt="Nelum Perera" class="w-16 h-16 rounded-full mx-auto">
                <h4 class="mt-4 text-xl font-semibold">Nelum Perera</h4>
                <p class="text-gray-600 mt-2">The rice met all expectations with superb quality, a fair price, and sufficient quantity.</p>
                <div class="mt-4 text-yellow-500">★★★★★</div>
            </div>
        </div>
    </section>
@endsection