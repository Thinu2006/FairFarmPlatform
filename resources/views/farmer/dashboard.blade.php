@extends('layouts.farmer')

@section('title', 'ගොවියන්ගේ ප්‍රධාන පුවරුව')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
                <div class="w-full sm:w-auto">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-merriweather">
                        සාදරයෙන් පිළිගනිමු <span class="text-gray-800">{{ Auth::guard('farmer')->user()->FullName }}</span>!
                    </h1>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 sm:gap-20 mb-10">
            <!-- Total Orders -->
            <div class="w-full sm:w-1/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-gray-500">මුළු ඇණවුම්</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">{{ $stats['order_stats']['total_orders'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $stats['order_stats']['pending_orders'] }} තීරණය වෙමින් පවතී</p>
                        </div>
                        <div class="bg-black p-3 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-box-open text-gray-100 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue-->
            <div class="w-full sm:w-1/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-gray-500">මුළු ආදායම</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">රු. {{ $stats['revenue_stats']['total_revenue'], 2 }}</p>
                            <p class="text-sm text-gray-500 mt-1">පසුගිය දින 30: රු. {{ $stats['revenue_stats']['monthly_revenue'], 2 }}</p>
                        </div>
                        <div class="bg-black p-3 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-rupee-sign text-gray-100 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Listings -->
            <div class="w-full sm:w-1/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-gray-500">සක්‍රීය වී ලැයිස්තු</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">{{ $stats['listing_stats']['active_listings'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $stats['listing_stats']['low_stock_listings'] }} අඩු ගබඩා තොගය</p>
                        </div>
                        <div class="bg-black p-3 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-seedling text-gray-100 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <!-- Sales Chart -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">මාසික විකුණුම්</h3>
                </div>
                <div class="p-6 h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Paddy Sales Chart -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">ඔබගේ වී විකුණුම්</h3>
                </div>
                <div class="p-6 h-64">
                    <canvas id="paddySalesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Order Breakdown Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">ඇණවුම් තත්ත්වය විස්තර</h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Pie Chart -->
                    <div class="w-full md:w-1/2 h-64">
                        <canvas id="orderStatusChart"></canvas>
                    </div>

                    <!-- Status Legend -->
                    <div class="w-full md:w-1/2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($stats['detailed_order_status_counts'] as $status => $count)
                                @if($status !== 'buyer_cancelled' && $status !== 'farmer_cancelled')
                                    @php
                                        $config = $stats['status_configs'][$status] ?? [
                                            'text' => ucfirst($status),
                                            'color' => 'gray',
                                            'icon' => 'fa-circle-question',
                                            'chart_color' => 'rgba(158, 158, 158, 0.6)'
                                        ];
                                    @endphp
                                    <div class="flex items-center p-3 rounded-lg" style="background-color: {{ str_replace('0.6', '0.1', $config['chart_color']) }}">
                                        <div class="p-2 rounded-full mr-3" style="background-color: {{ str_replace('0.6', '0.3', $config['chart_color']) }}">
                                            <i class="fas {{ $config['icon'] }}" style="color: {{ str_replace('0.6', '1', $config['chart_color']) }}"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $config['text'] }}</p>
                                            <p class="text-sm text-gray-600">{{ $count }} ඇණවුම්</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <!-- Separate entries for cancellation types -->
                            @if(isset($stats['detailed_order_status_counts']['buyer_cancelled']))
                                @php $config = $stats['status_configs']['buyer_cancelled']; @endphp
                                <div class="flex items-center p-3 rounded-lg" style="background-color: {{ str_replace('0.6', '0.1', $config['chart_color']) }}">
                                    <div class="p-2 rounded-full mr-3" style="background-color: {{ str_replace('0.6', '0.3', $config['chart_color']) }}">
                                        <i class="fas {{ $config['icon'] }}" style="color: {{ str_replace('0.6', '1', $config['chart_color']) }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $config['text'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $stats['detailed_order_status_counts']['buyer_cancelled'] }} ඇණවුම්</p>
                                    </div>
                                </div>
                            @endif

                            @if(isset($stats['detailed_order_status_counts']['farmer_cancelled']))
                                @php $config = $stats['status_configs']['farmer_cancelled']; @endphp
                                <div class="flex items-center p-3 rounded-lg" style="background-color: {{ str_replace('0.6', '0.1', $config['chart_color']) }}">
                                    <div class="p-2 rounded-full mr-3" style="background-color: {{ str_replace('0.6', '0.3', $config['chart_color']) }}">
                                        <i class="fas {{ $config['icon'] }}" style="color: {{ str_replace('0.6', '1', $config['chart_color']) }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $config['text'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $stats['detailed_order_status_counts']['farmer_cancelled'] }} ඇණවුම්</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">මෑත ඇණවුම්</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($stats['recent_orders'] as $order)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start">
                        <div class="bg-{{ $order['status_color'] }}-100 p-2 rounded-full mr-4">
                            <i class="fas fa-{{ $order['status_icon'] }} text-{{ $order['status_color'] }}-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $order['title'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $order['description'] }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $order['time'] }}</p>
                        </div>
                        <span class="bg-{{ $order['status_color'] }}-100 text-{{ $order['status_color'] }}-800 text-xs px-2 py-1 rounded-full">{{ $order['status_text'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-4 text-center border-t border-gray-100">
                <a href="{{ route('farmer.orders.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">සියලුම ඇණවුම් බලන්න →</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stats['sales_chart']['labels']) !!},
                datasets: [{
                    label: 'විකුණුම් (රු.)',
                    data: {!! json_encode($stats['sales_chart']['data']) !!},
                    backgroundColor: 'rgba(31, 69, 41, 0.1)',
                    borderColor: 'rgba(31, 69, 41, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'රු. ' + value;
                            }
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

        // Paddy Sales Chart
        const paddySalesCtx = document.getElementById('paddySalesChart').getContext('2d');
        const paddySalesChart = new Chart(paddySalesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stats['paddy_sales']['labels']) !!},
                datasets: [
                    {
                        label: 'විකුණු ප්‍රමාණය (kg)',
                        data: {!! json_encode($stats['paddy_sales']['quantities']) !!},
                        backgroundColor: 'rgba(31, 69, 41, 0.7)',
                        borderColor: 'rgba(31, 69, 41, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'ආදායම (රු.)',
                        data: {!! json_encode($stats['paddy_sales']['revenues']) !!},
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 1,
                        type: 'line',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'ප්‍රමාණය (kg)'
                        },
                        beginAtZero: true
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'ආදායම (රු.)'
                        },
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.datasetIndex === 0) {
                                    label += context.raw + ' kg ';
                                } else {
                                    label += 'රු. ' + context.raw.toFixed(2);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        const orderStatusChart = new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_map(function($status) use ($stats) {
                    return $stats['status_configs'][$status]['text'] ?? ucfirst($status);
                }, array_keys($stats['order_status_counts']))) !!},
                datasets: [{
                    data: {!! json_encode(array_values($stats['order_status_counts'])) !!},
                    backgroundColor: {!! json_encode(array_map(function($status) use ($stats) {
                        return $stats['status_configs'][$status]['chart_color'] ?? 'rgba(158, 158, 158, 0.6)';
                    }, array_keys($stats['order_status_counts']))) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
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
    });
</script>
@endsection
