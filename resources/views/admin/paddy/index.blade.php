@extends('layouts.admin')

@section('title', 'Paddy List')

@section('content')
<header class="text-center mb-6">
    <h1 class="text-5xl font-rowdies font-bold text-gray-800 mb-4">List of Paddy Types</h1>
</header>

<div class="w-full flex justify-end mb-10">
    <a href="{{ route('admin.paddy.create') }}" class="px-5 py-2 bg-green-700 text-white rounded-lg shadow-md hover:bg-green-900 transition-all">+ Add New Type</a>
</div>

<!-- Paddy Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
    @if ($paddytypes->isNotEmpty())
        @foreach ($paddytypes as $paddy)
            <div class="bg-white p-5 rounded-xl shadow-lg text-center border border-green-700 hover:shadow-xl transition-all">
                @if ($paddy->Image)
                    <img src="{{ asset('storage/' . $paddy->Image) }}" alt="Paddy Type Image" class="w-full h-40 object-cover rounded-md">
                @else
                    <p class="text-gray-600">No Image Available</p>
                @endif
                <p class="font-bold mt-3 text-lg">{{ $paddy->PaddyName }}</p>
                <p class="text-gray-700"><strong>Max Price:</strong> Rs. {{ $paddy->MaxPricePerKg }}</p>
                <div class="mt-4 flex gap-6 justify-center">
                    <a href="{{ route('admin.paddy.edit', $paddy->PaddyID) }}" class="flex-1 text-center px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-800 transition-all">Edit</a>

                    <!-- Delete Button with a DELETE form -->
                    <form action="{{ route('admin.paddy.destroy', $paddy->PaddyID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-800 transition-all">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-gray-600 text-center">No paddy types available.</p>
    @endif
@endsection