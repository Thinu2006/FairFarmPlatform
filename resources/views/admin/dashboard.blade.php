@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<header class="text-center mb-12">
    <h1 class="text-5xl font-rowdies font-bold text-gray-800 mb-4">Admin Dashboard</h1>
</header>

<!-- Statistics -->
<div class="grid grid-cols-3 gap-8 mb-16">
    <div class="bg-[#F5EFE6] text-black p-10 text-center rounded shadow border border-gray-300">
        <p class="text-xl font-OpenSans font-bold">No of Farmers</p>
        <p class="text-2xl font-bold"></p>
    </div>
    <div class="bg-[#F5EFE6] text-black p-10 text-center rounded shadow border border-gray-300">
        <p class="text-xl font-OpenSans font-bold">No of Buyers</p>
        <p class="text-2xl font-bold"></p>
    </div>
    <div class="bg-[#F5EFE6] text-black p-10 text-center rounded shadow border border-gray-300">
        <p class="text-xl font-OpenSans font-bold">No of Orders</p>
        <p class="text-2xl font-bold"></p>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-2 gap-8">
    <div class="bg-white p-5 rounded shadow">
        <h2 class="text-lg font-OpenSans font-bold mb-4 text-center">Top Selling Paddy Types</h2>
        <!-- Chart Here -->
    </div>
    <div class="bg-white p-5 rounded shadow">
        <h2 class="text-lg font-OpenSans font-bold mb-4 text-center">Sales Over the Year</h2>
        <!-- Chart Here -->
    </div>
</div>
@endsection
