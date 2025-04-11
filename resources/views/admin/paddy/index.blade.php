@extends('layouts.admin')

@section('title', 'Paddy List')

@section('content')
<div class="rounded-2xl bg-gray-50 font-sans md:p-4 p-1">
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 font-merriweather">Confirm Deletion</h3>
            </div>
            <p class="text-gray-600 mb-6 font-open-sans">Are you sure you want to delete this paddy type? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition font-open-sans">
                    Cancel
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition font-open-sans">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:justify-between ">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 font-merriweather">Paddy Types Management</h1>
                </div>
                @if ($paddytypes->isNotEmpty())
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all font-open-sans">
                        <i class="fas fa-plus mr-2"></i> Add New Type
                    </a>
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-8 md:mt-12">
        @if ($paddytypes->isNotEmpty())
        <!-- Paddy Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach ($paddytypes as $paddy)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1">
                <!-- Image with action buttons -->
                <div class="relative h-48 w-full bg-gray-100">
                    @if ($paddy->Image)
                        <img src="{{ asset('storage/' . $paddy->Image) }}" alt="{{ $paddy->PaddyName }}" 
                             class="h-full w-full object-cover">
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-seedling text-5xl mb-2"></i>
                        </div>
                    @endif
                    
                    <!-- Floating action buttons -->
                    <div class="absolute top-3 right-3 flex space-x-2">
                        <a href="{{ route('admin.paddy.edit', $paddy->PaddyID) }}" 
                           class="p-2 bg-white rounded-full shadow-md text-green-600 hover:bg-green-50 transition-colors"
                           title="Edit">
                            <i class="fas fa-pencil-alt text-sm"></i>
                        </a>
                        <button onclick="showDeleteModal('{{ route('admin.paddy.destroy', $paddy->PaddyID) }}')"
                                class="p-2 bg-white rounded-full shadow-md text-red-600 hover:bg-red-50 transition-colors"
                                title="Delete">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Card content -->
                <div class="p-4 mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 ">{{ $paddy->PaddyName }}</h3>
                            <p class="text-xs text-gray-500 mt-1">ID: {{ $paddy->PaddyID }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Min Price:</span>
                            <span class="text-sm font-medium text-blue-600">Rs. {{ number_format($paddy->MinPricePerKg, 2) }}/kg</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-sm font-medium text-gray-500">Max Price:</span>
                            <span class="text-sm font-medium text-green-600">Rs. {{ number_format($paddy->MaxPricePerKg, 2) }}/kg</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm p-8 text-center max-w-md mx-auto">
            <div class="mx-auto h-20 w-20 rounded-full bg-green-50 flex items-center justify-center text-green-600 mb-4">
                <i class="fas fa-seedling text-3xl"></i>
            </div>
            <h3 class="text-base font-bold text-gray-900 font-merriweather">No Paddy Types Found</h3>
            <p class="mt-2 text-sm text-gray-500 font-open-sans">Start by adding your first paddy variety to the system.</p>
            <div class="mt-6">
                <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all font-open-sans">
                    <i class="fas fa-plus mr-2"></i> Add Paddy Type
                </a>
            </div>
        </div>
        @endif
    </main>
</div>

<script>
    function showDeleteModal(url) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = url;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection