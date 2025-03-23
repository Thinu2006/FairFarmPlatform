@extends('layouts.app')

@section('content')

    <section class="relative w-full h-64 bg-cover bg-center flex items-center justify-center" style="background-image: url('./../../Images/BuyerLoginBG.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center px-6 text-center">
            <h2 class="text-white text-3xl md:text-4xl font-bold">All Paddy Products</h2>
            <form action="search.php" method="GET" class="mt-4">
                <input type="text" name="query" placeholder="Search products..." class="px-4 py-2 rounded-md text-gray-900">
                <button type="submit" class="bg-[#1F4529] text-white px-4 py-2 rounded-md hover:bg-green-800">Search</button>
            </form>
        </div>
    </section>
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
                        <li>&bull; {{ $paddy->farmer->FullName }}</li> <!-- Updated to FullName -->
                        <li>&bull; {{ $paddy->farmer->Address }}</li> <!-- Updated to Address -->
                    </ul>

                    <!-- Read More Button -->
                    <button class="mt-4 bg-[#1F4529] text-white px-4 py-2 rounded-md hover:bg-green-800 transition duration-300">
                        Read More
                    </button>
                </div>
            @endforeach
        </div>
    </section>
@endsection