@extends('layouts.app')

@section('title', 'Sales Records')

@section('content')
<!-- Main Sales Card -->
<div class="bg-white rounded-xl shadow-xl p-8">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Sales Records</h1>
            <p class="text-xl text-gray-600">Track all your fish sales and transactions</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Record New Sale
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Sales Records</h3>
            
            <!-- Quick Filter Buttons -->
            <div class="flex flex-wrap gap-2 mb-4">
                <a href="{{ route('sales.index', ['period' => 'today']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'today' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Today
                </a>
                <a href="{{ route('sales.index', ['period' => 'yesterday']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'yesterday' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Yesterday
                </a>
                <a href="{{ route('sales.index', ['period' => 'this_week']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'this_week' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    This Week
                </a>
                <a href="{{ route('sales.index', ['period' => 'last_week']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'last_week' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Last Week
                </a>
                <a href="{{ route('sales.index', ['period' => 'this_month']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'this_month' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    This Month
                </a>
                <a href="{{ route('sales.index', ['period' => 'last_month']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'last_month' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Last Month
                </a>
                <a href="{{ route('sales.index') }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ !request('period') && !request('date_from') ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Time
                </a>
            </div>

            <!-- Advanced Filters -->
            <form method="GET" action="{{ route('sales.index') }}" class="space-y-4">
                <!-- Search Input -->
                <div>
                    <label for="search" class="form-label">Search Sales</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by customer name, product, or notes..." 
                               class="form-input pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Date and Product Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="form-input">
                    </div>
                    <div>
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="form-input">
                    </div>
                    <div>
                        <label for="fish_id" class="form-label">Product Type</label>
                        <select id="fish_id" name="fish_id" class="form-input">
                            <option value="">All Products</option>
                            @foreach($fish as $fishItem)
                                <option value="{{ $fishItem->id }}" {{ request('fish_id') == $fishItem->id ? 'selected' : '' }}>
                                    {{ $fishItem->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search & Filter
                        </button>
                        <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    @if($totalSales > 0 || $totalQuantity > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="stat-label">Total Sales</p>
                    <p class="stat-value">₱{{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="stat-label">Total Quantity</p>
                    <p class="stat-value">{{ number_format($totalQuantity, 2) }} kg</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="stat-label">Avg. Price/kg</p>
                    <p class="stat-value">₱{{ $totalQuantity > 0 ? number_format($totalSales / $totalQuantity, 2) : '0.00' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Sales Table -->
    @if($sales->count() > 0)
        <div class="card">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">Date & Time</th>
                            <th class="table-header-cell">Fish</th>
                            <th class="table-header-cell">Customer</th>
                            <th class="table-header-cell">Quantity</th>
                            <th class="table-header-cell">Price/kg</th>
                            <th class="table-header-cell">Total</th>
                            <th class="table-header-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach($sales as $sale)
                            <tr>
                                <td class="table-cell">
                                    <div>
                                        <div class="font-medium">{{ $sale->sale_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $sale->sale_date->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <div>
                                        <div class="font-medium">{{ $sale->fish->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $sale->fish->type }}</div>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    {{ $sale->customer_name ?: 'Walk-in Customer' }}
                                </td>
                                <td class="table-cell">
                                    {{ number_format($sale->quantity_sold, 2) }} kg
                                </td>
                                <td class="table-cell">
                                    ₱{{ number_format($sale->price_per_kilo, 2) }}
                                </td>
                                <td class="table-cell font-medium text-green-600">
                                    ₱{{ number_format($sale->total_price, 2) }}
                                </td>
                                <td class="table-cell">
                                    <div class="flex gap-3">
                                        <a href="{{ route('sales.show', $sale) }}" class="text-ocean-600 hover:text-ocean-900 text-sm">
                                            View
                                        </a>
                                        <a href="{{ route('sales.edit', $sale) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Are you sure you want to delete this sale?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $sales->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No sales recorded</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by recording your first sale.</p>
            <div class="mt-6">
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Record Sale
                </a>
            </div>
        </div>
    @endif
</div>
<!-- Close main sales card -->
</div>
@endsection
