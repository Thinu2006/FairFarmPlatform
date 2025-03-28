@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="rounded-2xl bg-gray-50 md:p-4 p-1">
    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between justify-center">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard Overview</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-8 md:mt-12">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-10 mb-10">
            <!-- Farmers Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="p-6 flex items-center">
                    <div class="p-3 rounded-full bg-gray-300 mr-4">
                        <i class="fas fa-tractor text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Farmers</p>
                        <p class="text-2xl font-bold text-gray-900">100</p>
                    </div>
                </div>
            </div>

            <!-- Buyers Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="p-6 flex items-center">
                    <div class="p-3 rounded-full bg-gray-300 mr-4">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Buyers</p>
                        <p class="text-2xl font-bold text-gray-900">100</p>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="p-6 flex items-center">
                    <div class="p-3 rounded-full bg-gray-300 mr-4">
                        <i class="fas fa-box-open text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">100</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Selling Paddy Types -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-5 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-pie mr-2 "></i>
                        Top Selling Paddy Types
                    </h2>
                </div>
                <div class="p-4 h-80">
                    <!-- Chart Container -->
                    <canvas id="paddyTypesChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Sales Over Time -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-5 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-line mr-2 "></i>
                        Sales Over Time
                    </h2>
                </div>
                <div class="p-4 h-80">
                    <!-- Chart Container -->
                    <canvas id="salesChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>


@endsection