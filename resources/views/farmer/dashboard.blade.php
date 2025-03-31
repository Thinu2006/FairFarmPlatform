@extends('layouts.farmer')

@section('title', 'Farmer Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
                <div class="w-full sm:w-auto">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-merriweather">
                        Welcome Back, <span class="text-gray-800">{{ Auth::guard('farmer')->user()->FullName }}</span>!
                    </h1>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <!-- Total Orders Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Orders</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">24</p>
                        </div>
                        <div class="bg-black p-3 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-box-open text-gray-100 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">Rs 1,24,500</p>
                        </div>
                        <div class="bg-black p-3 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-rupee-sign text-gray-100 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Products Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Products</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">8</p>
                        </div>
                        <div class="bg-black p-3 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-seedling text-gray-100 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Sales Performance</h3>
                    <!-- <div class="mt-2 md:mt-0">
                        <select class="bg-gray-50 border border-gray-300 text-gray-700 py-1 px-3 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option>Last 7 Days</option>
                            <option selected>Last Month</option>
                            <option>Last Year</option>
                        </select>
                    </div> -->
                </div>
            </div>
            <div class="p-6">
                <!-- Chart Placeholder with better styling -->
                <div class="relative w-full h-64 md:h-80 bg-gray-50 rounded-lg flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-chart-line text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Sales data visualization</p>
                        <p class="text-sm text-gray-400 mt-1">Chart will appear here when data is available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <!-- <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start">
                        <div class="bg-green-100 p-2 rounded-full mr-4">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">New order received</p>
                            <p class="text-sm text-gray-500 mt-1">Order ID:123 for 50kg of Basmati </p>
                            <p class="text-xs text-gray-400 mt-2">2 hours ago</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Approve</span>
                    </div>
                </div>
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-2 rounded-full mr-4">
                            <i class="fas fa-truck text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Order shipped</p>
                            <p class="text-sm text-gray-500 mt-1">Order ID:100 has been dispatched</p>
                            <p class="text-xs text-gray-400 mt-2">Yesterday</p>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Shipped</span>
                    </div>
                </div>
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start">
                        <div class="bg-yellow-100 p-2 rounded-full mr-4">
                            <i class="fas fa-exclamation-circle text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Low stock alert</p>
                            <p class="text-sm text-gray-500 mt-1">Nadu stock is below 100kg</p>
                            <p class="text-xs text-gray-400 mt-2">2 days ago</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Attention</span>
                    </div>
                </div>
            </div>
            <div class="p-4 text-center border-t border-gray-100">
                <a href="#" class="text-green-600 hover:text-green-800 text-sm font-medium">View all activity →</a>
            </div>
        </div> -->
    </div>
</div>
@endsection