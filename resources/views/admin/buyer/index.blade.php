@extends('layouts.admin')

@section('title', 'Buyer List')

@section('content')
<header class="text-center mb-6">
    <h1 class="text-5xl font-rowdies font-bold text-gray-800 mb-4">Buyer List</h1>
</header>
<!-- Farmers Table -->
<table class="table-auto w-full border-collapse border border-gray-300 text-center">
    <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-400 px-6 py-4">ID</th>
            <th class="border border-gray-400 px-6 py-4">Full Name</th>
            <th class="border border-gray-400 px-6 py-4">NIC</th>
            <th class="border border-gray-400 px-6 py-4">Contact No</th>
            <th class="border border-gray-400 px-6 py-4">Address</th>
            <th class="border border-gray-400 px-6 py-4">Email</th>
            <th class="border border-gray-400 px-6 py-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($buyers as $buyer)
            <tr class="bg-white">
                <td class="border border-gray-400 px-4 py-2">{{ $buyer->BuyerID }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $buyer->FullName }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $buyer->NIC }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $buyer->ContactNo }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $buyer->Address }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $buyer->Email }}</td>
                <td class="border border-gray-400 px-4 py-2 text-center">
                    <div class="flex justify-center gap-2">
                        <form action="{{ route('admin.buyer.destroy', $buyer->BuyerID) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center border border-gray-400 px-4 py-2">No Data Found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection