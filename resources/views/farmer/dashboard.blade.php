@extends('layouts.farmer')

@section('title', 'Farmer Dashboard')

@section('content')
<header class="text-center mb-12">
    <h1 class="text-5xl font-rowdies font-bold text-gray-800 mb-4">Welcome Farmer</h1>
</header>

<!-- Statistics -->
<div class="grid grid-cols-3 gap-8 mb-16">
    <div class="bg-[#F5EFE6] text-black p-10 text-center rounded shadow border border-gray-300">
        <p class="text-xl font-OpenSans font-bold">Total Orders</p>
        <p class="text-2xl font-bold"></p>
    </div>
    <div class="bg-[#F5EFE6] text-black p-10 text-center rounded shadow border border-gray-300">
        <p class="text-xl font-OpenSans font-bold">Total Revenue (Rs)</p>
        <p class="text-2xl font-bold"></p>
    </div>
    <div class="bg-[#F5EFE6] text-black p-10 text-center rounded shadow border border-gray-300">
        <p class="text-xl font-OpenSans font-bold">Active Products</p>
        <p class="text-2xl font-bold"></p>
    </div>
</div>

<!-- Sales Chart UI -->
<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h3 class="text-xl font-semibold text-center mb-4">Sales Over the Year</h3>
    <!-- <div class="relative w-full h-40 flex flex-col justify-end border-l-2 border-b-2 border-gray-600 p-4">
        <div class="absolute left-0 top-0 h-full w-full flex flex-col justify-between">
            <div class="border-t border-gray-400 w-full"></div>
            <div class="border-t border-gray-400 w-full"></div>
            <div class="border-t border-gray-400 w-full"></div>
        </div>

        <div class="absolute bottom-0 left-0 w-full flex justify-around items-end">
            <div class="flex flex-col items-center">
                <div class="bg-success w-3 h-6 rounded-md"></div>
                <p class="mt-1 text-sm">Jan</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-success w-3 h-12 rounded-md"></div>
                <p class="mt-1 text-sm">Feb</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-success w-3 h-16 rounded-md"></div>
                <p class="mt-1 text-sm">Mar</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-success w-3 h-8 rounded-md"></div>
                <p class="mt-1 text-sm">Apr</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-success w-3 h-20 rounded-md"></div>
                <p class="mt-1 text-sm">May</p>
            </div>
        </div>
    </div> -->

@endsection
