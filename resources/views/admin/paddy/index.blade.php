@extends('layouts.admin')

@section('title', 'Paddy List')

@section('content')
<div class="rounded-2xl bg-gray-50 font-sans">
    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden sm:rounded-2xl mb-6">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:justify-between ">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 font-merriweather">Paddy Types Management</h1>
                    <p class="mt-1 text-sm text-gray-500 font-open-sans">View and manage all available paddy varieties</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all font-open-sans">
                        <i class="fas fa-plus mr-2"></i> Add New Type
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 font-open-sans">
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
                            <span class="text-sm">No image available</span>
                        </div>
                    @endif
                    
                    <!-- Floating action buttons -->
                    <div class="absolute top-3 right-3 flex space-x-2">
                        <a href="{{ route('admin.paddy.edit', $paddy->PaddyID) }}" 
                           class="p-2 bg-white rounded-full shadow-md text-green-600 hover:bg-green-50 transition-colors"
                           title="Edit">
                            <i class="fas fa-pencil-alt text-sm"></i>
                        </a>
                        <form action="{{ route('admin.paddy.destroy', $paddy->PaddyID) }}" method="POST"
                              onsubmit="return confirm('Delete this paddy type?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-2 bg-white rounded-full shadow-md text-red-600 hover:bg-red-50 transition-colors"
                                    title="Delete">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Card content -->
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 font-merriweather">{{ $paddy->PaddyName }}</h3>
                            <p class="text-xs text-gray-500 mt-1 font-open-sans">ID: {{ $paddy->PaddyID }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-[4px] rounded-full text-xs font-medium bg-green-100 text-green-800 font-open-sans">
                            Rs. {{ number_format($paddy->MaxPricePerKg, 2) }}/kg
                        </span>
                    </div>
                    
                    <!-- Additional details -->
                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-end text-xs text-gray-500 font-open-sans">
                        <span>
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ $paddy->created_at->format('M d, Y') }}
                        </span>
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
            <h3 class="text-lg font-medium text-gray-900 font-merriweather">No paddy types found</h3>
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
@endsection