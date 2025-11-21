@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Main Dashboard Card -->
<div class="bg-white rounded-xl shadow-xl p-8 mb-8">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
            <p class="text-xl text-gray-600">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Record Sale
            </a>
            <a href="{{ route('fish.create') }}" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Add Fish
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Today's Sales -->
        <div class="stat-card">
            <div class="stat-icon sales">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <p class="stat-value">₱{{ number_format($todaySales, 2) }}</p>
            <p class="stat-label">Today's Sales</p>
        </div>

        <!-- Today's Expenses -->
        <div class="stat-card">
            <div class="stat-icon expenses">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="stat-value">₱{{ number_format($todayExpenses, 2) }}</p>
            <p class="stat-label">Today's Expenses</p>
        </div>

        <!-- Today's Profit -->
        <div class="stat-card">
            <div class="stat-icon profit">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="stat-value">₱{{ number_format($todayProfit, 2) }}</p>
            <p class="stat-label">Today's Profit</p>
        </div>

        <!-- Total Fish Types -->
        <div class="stat-card">
            <div class="stat-icon fish">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <p class="stat-value">{{ $totalFishTypes }}</p>
            <p class="stat-label">Fish Types</p>
        </div>
    </div>

    <!-- Monthly Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Weekly Sales Trend</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach($weeklyData as $data)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">{{ $data['date'] }}</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        <div class="bg-ocean-600 h-2 rounded-full" style="width: {{ $monthSales > 0 ? ($data['sales'] / $monthSales * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">₱{{ number_format($data['sales'], 0) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Monthly Stats -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">This Month</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sales</span>
                        <span class="font-medium text-green-600">₱{{ number_format($monthSales, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Expenses</span>
                        <span class="font-medium text-red-600">₱{{ number_format($monthExpenses, 2) }}</span>
                    </div>
                    <div class="border-t pt-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900">Net Profit</span>
                            <span class="font-bold text-{{ $monthProfit >= 0 ? 'green' : 'red' }}-600">₱{{ number_format($monthProfit, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Alert -->
            @if($lowStockItems > 0)
            <div class="card border-yellow-200 bg-yellow-50">
                <div class="card-body">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-yellow-800">Low Stock Alert</p>
                            <p class="text-sm text-yellow-700">{{ $lowStockItems }} item(s) running low</p>
                        </div>
                    </div>
                    <a href="{{ route('fish.index') }}" class="mt-3 inline-block text-sm text-yellow-800 hover:text-yellow-900 font-medium">
                        View Inventory →
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Sales -->
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Recent Sales</h3>
                <a href="{{ route('sales.index') }}" class="text-sm text-ocean-600 hover:text-ocean-900">View all</a>
            </div>
            <div class="card-body">
                @if($recentSales->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentSales as $sale)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $sale->fish->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $sale->quantity_sold }}kg • {{ $sale->sale_date->format('M d, Y') }}</p>
                                </div>
                                <span class="font-medium text-green-600">₱{{ number_format($sale->total_price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No sales recorded yet</p>
                @endif
            </div>
        </div>

        <!-- Top Selling Fish -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Top Selling Fish (This Month)</h3>
            </div>
            <div class="card-body">
                @if($topSellingFish->count() > 0)
                    <div class="space-y-4">
                        @foreach($topSellingFish as $item)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->fish->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->total_sold }}kg sold</p>
                                </div>
                                <span class="font-medium text-ocean-600">₱{{ number_format($item->total_revenue, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No sales data available</p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Close main dashboard card -->
</div>
@endsection
