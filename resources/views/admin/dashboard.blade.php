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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6 mb-10">
            <!-- Farmers Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="p-6 flex items-center">
                    <div class="p-3 rounded-full bg-black mr-4">
                        <i class="fas fa-tractor text-gray-100 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Total Farmers</p>
                        <p class="text-xl font-bold text-gray-900">{{ $stats['total_farmers'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Buyers Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="p-6 flex items-center">
                    <div class="p-3 rounded-full bg-black mr-4">
                        <i class="fas fa-shopping-cart text-gray-100 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Total Buyers</p>
                        <p class="text-xl font-bold text-gray-900">{{ $stats['total_buyers'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="p-6 flex items-center">
                    <div class="p-3 rounded-full bg-black mr-4">
                        <i class="fas fa-box-open text-gray-100 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Total Orders</p>
                        <p class="text-xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Delivery Revenue Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                <div class="p-6 flex items-center">
                    <div class="p-3 rounded-full bg-black mr-4">
                        <i class="fas fa-truck text-gray-100 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Delivery Revenue</p>
                        <p class="text-xl font-bold text-gray-900">Rs. {{ number_format($stats['shipping_revenue'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <!-- Order Status Breakdown Chart -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Status Breakdown</h3>
                <div class="h-64">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>

            <!-- User Distribution Chart -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">User Distribution</h3>
                <div class="h-64">
                    <canvas id="userDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Performers Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <!-- Top 3 Buyers Chart -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 3 Buyers by Orders</h3>
                <div class="h-64">
                    <canvas id="topBuyersChart"></canvas>
                </div>
            </div>

            <!-- Top 3 Farmers Chart -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 3 Farmers by Orders</h3>
                <div class="h-64">
                    <canvas id="topFarmersChart"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Order Status Breakdown Chart (Bar Chart)
        // Order Status Breakdown Chart (Bar Chart)
const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
const orderStatusChart = new Chart(orderCtx, {
    type: 'bar',
    data: {
        labels: ['Pending', 'Processing', 'Delivery Started', 'Completed', 'Farmer Cancelled', 'Buyer Cancelled'],
        datasets: [{
            label: 'Number of Orders',
            data: [
                {{ $stats['pending_orders_count'] }},
                {{ $stats['processing_orders_count'] }},
                {{ $stats['delivery_started_orders_count'] }},
                {{ $stats['completed_orders_count'] }},
                {{ $stats['farmer_cancelled_orders_count'] }},
                {{ $stats['buyer_cancelled_orders_count'] }}
            ],
            backgroundColor: [
                'rgba(255, 193, 7, 0.6)',   // Pending - Amber
                'rgba(31, 69, 41, 0.6)',    // Processing - Dark Green
                'rgba(76, 175, 80, 0.6)',   // Delivery Started - Green
                'rgba(139, 195, 74, 0.6)',  // Completed - Light Green
                'rgba(244, 67, 54, 0.6)',   // Farmer Cancelled - Red
                'rgba(255, 87, 34, 0.6)'    // Buyer Cancelled - Deep Orange
            ],
            borderColor: [
                'rgba(255, 193, 7, 1)',
                'rgba(31, 69, 41, 1)',
                'rgba(76, 175, 80, 1)',
                'rgba(139, 195, 74, 1)',
                'rgba(244, 67, 54, 1)',
                'rgba(255, 87, 34, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

        // User Distribution Chart (Doughnut Chart)
        const userCtx = document.getElementById('userDistributionChart').getContext('2d');
        const userDistributionChart = new Chart(userCtx, {
            type: 'doughnut',
            data: {
                labels: ['Farmers', 'Buyers'],
                datasets: [{
                    data: [{{ $stats['total_farmers'] }}, {{ $stats['total_buyers'] }}],
                    backgroundColor: [
                        'rgba(31, 69, 41, 0.6)',  // Dark Green (sidebar color)
                        'rgba(139, 195, 74, 0.6)' // Light Green
                    ],
                    borderColor: [
                        'rgba(31, 69, 41, 1)',
                        'rgba(139, 195, 74, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Top 3 Buyers Chart (Horizontal Bar Chart)
        const topBuyersCtx = document.getElementById('topBuyersChart').getContext('2d');
        const topBuyersChart = new Chart(topBuyersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stats['top_buyers']->pluck('FullName')) !!},
                datasets: [{
                    label: 'Number of Orders',
                    data: {!! json_encode($stats['top_buyers']->pluck('orders_count')) !!},
                    backgroundColor: 'rgba(31, 69, 41, 0.6)',
                    borderColor: 'rgba(31, 69, 41, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Top 3 Farmers Chart (Horizontal Bar Chart)
        const topFarmersCtx = document.getElementById('topFarmersChart').getContext('2d');
        const topFarmersChart = new Chart(topFarmersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stats['top_farmers']->pluck('FullName')) !!},
                datasets: [{
                    label: 'Number of Orders',
                    data: {!! json_encode($stats['top_farmers']->pluck('orders_count')) !!},
                    backgroundColor: 'rgba(76, 175, 80, 0.6)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endsection