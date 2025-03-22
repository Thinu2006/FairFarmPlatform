@extends('layouts.farmer')

@section('title', 'Farmer Dashboard')

@section('content')
<!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto">
    <div class="max-w-6xl mx-auto p-8 rounded-2xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-green-900">Listed Paddy Types</h1>
            <a href="{{ route('farmer.paddy.listing.form') }}" class="px-6 py-3 bg-green-700 text-white rounded-xl shadow-md hover:bg-green-800 transition-all transform hover:scale-105">
                + List New Type
            </a>
        </div>

        <!-- Paddy Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">
            @foreach ($sellingPaddyTypes as $paddy)
                <!-- Single Paddy Card -->
                <div class="bg-white p-6 rounded-2xl shadow-lg text-center border border-green-200 hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <!-- Paddy Image -->
                    <img src="{{ asset('storage/' . $paddy->paddyType->Image) }}" alt="Paddy" class="w-full h-48 object-cover rounded-xl mb-4">

                    <!-- Paddy Name -->
                    <p class="font-bold text-2xl text-green-900 mb-2">{{ $paddy->paddyType->PaddyName }}</p>

                    <!-- Price and Quantity -->
                    <p class="text-gray-700 text-lg mb-2">
                        <span class="font-semibold">Per 1Kg:</span> Rs. {{ $paddy->PriceSelected }}
                    </p>
                    <p class="text-gray-700 text-lg mb-4">
                        <span class="font-semibold">Available Quantity:</span> {{ $paddy->Quantity }}kg
                    </p>

                    <!-- Buttons for Delete and Update -->
                    <div class="mt-6 flex gap-10 justify-center">
                        <!-- Delete Form -->
                        <form action="{{ route('farmer.paddy.listing.destroy', $paddy->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-8 py-2 bg-green-800 text-white rounded-xl shadow-md hover:bg-green-700 transition-all transform hover:scale-105">
                                Delete
                            </button>
                        </form>

                        <!-- Update Link -->
                        <a href="{{ route('farmer.paddy.listing.edit', $paddy->id) }}" class=" px-5 py-2 bg-green-800 text-white rounded-xl shadow-md hover:bg-green-700 transition-all transform hover:scale-105">
                            Update
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection