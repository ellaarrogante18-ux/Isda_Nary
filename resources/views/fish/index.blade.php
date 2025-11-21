@extends('layouts.app')

@section('title', 'Fish Inventory')

@section('content')
<!-- Main Fish Inventory Card -->
<div class="bg-white rounded-xl shadow-xl p-8">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Fish Inventory</h1>
            <p class="text-xl text-gray-600">Manage your fish stock and pricing</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('fish.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Product
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Search & Filter Products</h3>
            
            <form method="GET" action="{{ route('fish.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="form-label">Search Products</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by name, type, or description..." 
                               class="form-input pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Stock Filter -->
                <div>
                    <label for="stock_status" class="form-label">Stock Status</label>
                    <select id="stock_status" name="stock_status" class="form-input">
                        <option value="">All Products</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                
                <!-- Search Buttons -->
                <div class="md:col-span-3 flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                    <a href="{{ route('fish.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Fish Grid -->
    @if($fish->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($fish as $fishItem)
                <div class="card">
                    @if($fishItem->image)
                        <img src="{{ asset('storage/' . $fishItem->image) }}" alt="{{ $fishItem->name }}" class="w-full h-48 object-cover rounded-t-lg">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-cyan-100 to-teal-100 rounded-t-lg flex items-center justify-center">
                            <svg class="w-16 h-16 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $fishItem->name }}</h3>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $fishItem->quantity_available > 5 ? 'bg-green-100 text-green-800' : ($fishItem->quantity_available > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $fishItem->quantity_available > 5 ? 'In Stock' : ($fishItem->quantity_available > 0 ? 'Low Stock' : 'Out of Stock') }}
                            </span>
                        </div>
                        
                        <!-- Price Highlight -->
                        <div class="bg-teal-50 border border-teal-200 rounded-lg p-3 mb-3">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-teal-600">₱{{ number_format($fishItem->price_per_kilo, 2) }}</div>
                                <div class="text-sm text-teal-700">per kilogram</div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-3">{{ $fishItem->type }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Available Stock:</span>
                                <span class="text-sm font-medium {{ $fishItem->quantity_available > 5 ? 'text-green-600' : ($fishItem->quantity_available > 0 ? 'text-yellow-600' : 'text-red-600') }}">{{ $fishItem->quantity_available }} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Total Value:</span>
                                <span class="text-sm font-medium text-cyan-600">₱{{ number_format($fishItem->quantity_available * $fishItem->price_per_kilo, 2) }}</span>
                            </div>
                        </div>

                        @if($fishItem->description)
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($fishItem->description, 100) }}</p>
                        @endif

                        <div class="flex gap-3">
                            <a href="{{ route('fish.show', $fishItem) }}" class="flex-1 btn btn-secondary text-center">
                                View
                            </a>
                            <a href="{{ route('fish.edit', $fishItem) }}" class="flex-1 btn btn-primary text-center">
                                Edit
                            </a>
                            @if($fishItem->quantity_available > 0)
                                <a href="{{ route('sales.create', ['fish_id' => $fishItem->id]) }}" class="flex-1 btn btn-success text-center">
                                    Sell
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $fish->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No fish in inventory</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding your first fish to the inventory.</p>
            <div class="mt-6">
                <a href="{{ route('fish.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Fish
                </a>
            </div>
        </div>
    @endif
</div>
<!-- Close main fish inventory card -->
</div>
@endsection
