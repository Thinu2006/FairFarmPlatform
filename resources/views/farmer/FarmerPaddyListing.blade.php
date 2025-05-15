@extends('layouts.farmer')

@section('title', 'My Paddy Listings')

@section('content')
<!-- Main Content -->
<main class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-1 sm:px-6 py-4 sm:py-6">
        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Confirm Deletion</h3>
                    <button onclick="hideDeleteModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-gray-700 mb-6" id="deleteModalText">Are you sure you want to delete this listing?</p>
                <div class="flex justify-end gap-3">
                    <button onclick="hideDeleteModal()" 
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
                <div class="w-full sm:w-auto">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-merriweather">My Paddy Listings</h1>
                </div>
                @if($listings->isNotEmpty())
                <div class="w-full sm:w-auto mt-2 sm:mt-0">
                    <a href="{{ route('farmer.paddy.listing.form') }}" 
                    class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-3 bg-green-700 hover:bg-green-800 text-white rounded-lg shadow-sm transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5 text-sm sm:text-base font-medium">
                        <i class="fas fa-plus mr-1 sm:mr-2"></i>
                        <span class="whitespace-nowrap">Add New Listing</span>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Paddy Cards Grid -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            @if($listings->isEmpty())
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($listings as $paddy)
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
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 font-merriweather">{{ $paddy->paddyType->PaddyName }}</h3>
                                
                                <div class="space-y-3 mb-5">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 text-sm sm:text-base">
                                            Price per bushel:
                                        </span>
                                        <span class="text-sm sm:text-base font-bold text-green-700">
                                            Rs. {{ number_format($paddy->PriceSelected, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 text-sm sm:text-base">
                                            Available:
                                        </span>
                                        <span class="text-sm sm:text-base font-bold {{ $paddy->Quantity <= 0 ? 'text-red-600' : 'text-green-700' }}">
                                            {{ number_format($paddy->Quantity) }} bu
                                            @if($paddy->Quantity <= 0 && isset($paddy->has_pending_orders) && $paddy->has_pending_orders)
                                                <span class="ml-1 text-xs bg-yellow-100 text-yellow-700 px-1 py-0.5 rounded">
                                                    {{ $paddy->pending_orders_count }} pending orders
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                    @if($paddy->Quantity <= 0 && isset($paddy->has_pending_orders) && $paddy->has_pending_orders)
                                        <div class="mt-2 bg-yellow-50 border-l-4 border-yellow-400 p-2 text-xs text-yellow-800">
                                            <p>You have pending orders but zero quantity available. Please update your quantity to fulfill these orders.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-between gap-2 sm:gap-3">
                                    <a href="{{ route('farmer.paddy.listing.edit', $paddy->id) }}" 
                                       class="flex-1 flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg transition-all text-xs sm:text-sm font-medium">
                                        <i class="fas fa-edit text-xs sm:text-sm"></i>
                                        <span>Edit</span>
                                    </a>
                                    
                                    <button type="button" 
                                            onclick="showDeleteModal('{{ $paddy->id }}', '{{ $paddy->paddyType->PaddyName }}')"
                                            class="flex-1 flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 bg-red-50 hover:bg-red-100 text-red-800 rounded-lg transition-all text-xs sm:text-sm font-medium">
                                        <i class="fas fa-trash-alt text-xs sm:text-sm"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</main>

<script>
    function showDeleteModal(id, paddyName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const text = document.getElementById('deleteModalText');
        
        // Set the form action
        form.action = `/farmer/paddy-listing/${id}`;
        
        // Update the modal text
        text.textContent = `Are you sure you want to delete your "${paddyName}" listing? This action cannot be undone.`;
        
        // Show the modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideDeleteModal();
        }
    });
</script>
@endsection