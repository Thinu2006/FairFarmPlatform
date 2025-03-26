@extends('layouts.farmer')

@section('title', 'My Paddy Listings')

@section('content')
<!-- Main Content -->
<main class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto ">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
                <div class="w-full sm:w-auto">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-merriweather">My Paddy Listings</h1>
                </div>
                @unless($sellingPaddyTypes->isEmpty())
                <div class="w-full sm:w-auto mt-2 sm:mt-0">
                    <a href="{{ route('farmer.paddy.listing.form') }}" 
                    class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-3 bg-green-700 hover:bg-green-800 text-white rounded-lg shadow-sm transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5 text-sm sm:text-base font-medium">
                        <i class="fas fa-plus mr-1 sm:mr-2"></i>
                        <span class="whitespace-nowrap">Add New Listing</span>
                    </a>
                </div>
                @endunless
            </div>
        </div>

        <!-- Paddy Cards Grid -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            @if($sellingPaddyTypes->isEmpty())
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 bg-green-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-seedling text-4xl text-green-600"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 font-merriweather">No Paddy Listings Yet</h3>
                    <p class="text-base text-gray-500 mb-6 max-w-md mx-auto">You haven't listed any paddy types to sell yet.</p>
                    <a href="{{ route('farmer.paddy.listing.form') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg shadow-sm transition-all">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Create First Listing
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
                    @foreach ($sellingPaddyTypes as $paddy)
                        <!-- Single Paddy Card -->
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200">
                            <!-- Paddy Image with fallback -->
                            <div class="relative w-full h-48 sm:h-56 bg-gray-100">
                                @if($paddy->paddyType->Image)
                                    <img src="{{ asset('storage/' . $paddy->paddyType->Image) }}" 
                                         alt="{{ $paddy->paddyType->PaddyName }}" 
                                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-seedling text-6xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Paddy Details -->
                            <div class="p-4 sm:p-5">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 font-merriweather">{{ $paddy->paddyType->PaddyName }}</h3>
                                
                                <div class="space-y-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 text-base sm:text-sm font-medium">
                                            Price per kg:
                                        </span>
                                        <span class="text-sm font-bold text-green-700">
                                            Rs. {{ number_format($paddy->PriceSelected) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 text-base sm:text-sm font-medium">
                                            Available:
                                        </span>
                                        <span class="text-sm font-bold text-green-700">
                                            {{ $paddy->Quantity }} kg
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-between gap-3">
                                    <a href="{{ route('farmer.paddy.listing.edit', $paddy->id) }}" 
                                       class="flex-1 flex items-center justify-center gap-2 px-3 py-2 sm:py-2.5 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg transition-all text-sm sm:text-base font-medium">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    
                                    <form action="{{ route('farmer.paddy.listing.destroy', $paddy->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this listing?');"
                                          class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full flex items-center justify-center gap-2 px-3 py-2 sm:py-2.5 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg transition-all text-sm sm:text-base font-medium">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</main>
@endsection