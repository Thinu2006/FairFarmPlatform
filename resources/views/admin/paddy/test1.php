@extends('layouts.admin')

@section('title', 'Paddy List')

@section('content')
<div class="rounded-2xl bg-gray-50">
    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden sm:rounded-2xl mb-6">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">Paddy Types Management</h1>
                    <p class="mt-1 text-sm text-gray-500">View and manage all available paddy varieties</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        <i class="fas fa-plus mr-2"></i> Add New Type
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-10 lg:px-6 py-10">
        @if ($paddytypes->isNotEmpty())
        <!-- Paddy Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($paddytypes as $paddy)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="h-48 bg-gray-100 flex items-center justify-center relative">
                    @if ($paddy->Image)
                        <img src="{{ asset('storage/' . $paddy->Image) }}" alt="{{ $paddy->PaddyName }}" class="h-full w-full object-cover">
                    @else
                        <div class="text-center p-4">
                            <i class="fas fa-seedling text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No image available</p>
                        </div>
                    @endif
                    <!-- Action buttons positioned on image -->
                    <div class="absolute top-2 right-2 flex space-x-2">
                        <a href="{{ route('admin.paddy.edit', $paddy->PaddyID) }}" 
                           class="p-2 bg-white bg-opacity-80 rounded-full text-green-700 hover:bg-green-100 transition-colors"
                           title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.paddy.destroy', $paddy->PaddyID) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this paddy type?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-2 bg-white bg-opacity-80 rounded-full text-red-600 hover:bg-red-100 transition-colors"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $paddy->PaddyName }}</h3>
                    <p class="text-gray-600 mb-1"><span class="font-semibold">ID:</span> {{ $paddy->PaddyID }}</p>
                    <p class="text-green-700 font-semibold">Max Price: Rs. {{ number_format($paddy->MaxPricePerKg, 2) }}/kg</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="mx-auto h-24 w-24 text-gray-400">
                <i class="fas fa-seedling text-5xl"></i>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No paddy types found</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding a new paddy variety.</p>
            <div class="mt-6">
                <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                    <i class="fas fa-plus mr-2"></i> Add Paddy Type
                </a>
            </div>
        </div>
        @endif
    </main>
</div>
@endsection


















@extends('layouts.admin')

@section('title', 'Paddy List')

@section('content')
<div class="rounded-2xl bg-gray-50">
    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden sm:rounded-2xl mb-6">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">Paddy Types Management</h1>
                    <p class="mt-1 text-sm text-gray-500">View and manage all available paddy varieties</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        <i class="fas fa-plus mr-2"></i> Add New Type
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-10 lg:px-6 py-10">
        @if ($paddytypes->isNotEmpty())
        <!-- Paddy Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-16">
            @foreach ($paddytypes as $paddy)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="h-48 bg-gray-100 flex items-center justify-center">
                    @if ($paddy->Image)
                        <img src="{{ asset('storage/' . $paddy->Image) }}" alt="{{ $paddy->PaddyName }}" class="h-full w-full object-cover">
                    @else
                        <div class="text-center p-4">
                            <i class="fas fa-seedling text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No image available</p>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $paddy->PaddyName }}</h3>
                    <p class="text-gray-600 mb-1"><span class="font-semibold">ID:</span> {{ $paddy->PaddyID }}</p>
                    <p class="text-green-700 font-semibold mb-4">Max Price: Rs. {{ number_format($paddy->MaxPricePerKg, 2) }}/kg</p>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.paddy.edit', $paddy->PaddyID) }}" class="flex-1 text-center px-3 py-2 bg-green-700 text-white font-medium rounded-md hover:bg-green-900 transition-colors">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.paddy.destroy', $paddy->PaddyID) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this paddy type?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-2 bg-green-700 text-white font-medium rounded-md hover:bg-green-900 transition-colors">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="mx-auto h-24 w-24 text-gray-400">
                <i class="fas fa-seedling text-5xl"></i>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No paddy types found</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding a new paddy variety.</p>
            <div class="mt-6">
                <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                    <i class="fas fa-plus mr-2"></i> Add Paddy Type
                </a>
            </div>
        </div>
        @endif
    </main>
</div>
@endsection




@extends('layouts.admin')

@section('title', 'Paddy List')

@section('content')
<div class="rounded-2xl bg-gray-50">
    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden sm:rounded-2xl mb-6">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">Paddy Types Management</h1>
                    <p class="mt-1 text-sm text-gray-500">View and manage all available paddy varieties</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        <i class="fas fa-plus mr-2"></i> Add New Type
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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
                            <h3 class="text-lg font-semibold text-gray-800">{{ $paddy->PaddyName }}</h3>
                            <p class="text-xs text-gray-500 mt-1">ID: {{ $paddy->PaddyID }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Rs. {{ number_format($paddy->MaxPricePerKg, 2) }}/kg
                        </span>
                    </div>
                    
                    <!-- Additional details can be added here -->
                    <!-- <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between text-xs text-gray-500">
                        <span>
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ $paddy->created_at->format('M d, Y') }}
                        </span>
                        <span>
                            <i class="fas fa-tag mr-1"></i>
                            {{ $paddy->category ?? 'Standard' }}
                        </span>
                    </div> -->
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
            <h3 class="text-lg font-medium text-gray-900">No paddy types found</h3>
            <p class="mt-2 text-sm text-gray-500">Start by adding your first paddy variety to the system.</p>
            <div class="mt-6">
                <a href="{{ route('admin.paddy.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                    <i class="fas fa-plus mr-2"></i> Add Paddy Type
                </a>
            </div>
        </div>
        @endif
    </main>
</div>
@endsection