@extends('layouts.app')

@section('title', 'Fish Details')

@section('content')
<!-- Main Fish Details Card -->
<div class="bg-white rounded-xl shadow-xl p-8 max-w-6xl mx-auto">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $fish->name }}</h1>
            <p class="text-xl text-gray-600">Fish Details & Sales History</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('fish.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
            <a href="{{ route('fish.edit', $fish) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Fish Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Image Section -->
        <div class="card">
            @if($fish->image)
                <img src="{{ asset('storage/' . $fish->image) }}" alt="{{ $fish->name }}" class="w-full h-64 object-cover rounded-t-lg">
            @else
                <div class="w-full h-64 bg-gradient-to-br from-ocean-100 to-fish-blue-100 rounded-t-lg flex items-center justify-center">
                    <svg class="w-24 h-24 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            @endif
            <div class="card-body">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $fish->name }}</h3>
                <p class="text-sm text-gray-600 mb-3">{{ $fish->type }}</p>
                @if($fish->description)
                    <p class="text-sm text-gray-600">{{ $fish->description }}</p>
                @endif
            </div>
        </div>

        <!-- Stock Information -->
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Information</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Available Quantity:</span>
                        <span class="text-lg font-bold text-gray-900">{{ number_format($fish->quantity_available, 2) }} kg</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Price per Kilo:</span>
                        <span class="text-lg font-bold text-green-600">₱{{ number_format($fish->price_per_kilo, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Value:</span>
                        <span class="text-xl font-bold text-ocean-600">₱{{ number_format($fish->quantity_available * $fish->price_per_kilo, 2) }}</span>
                    </div>
                </div>

                <!-- Add Stock Form -->
                <form action="{{ route('fish.add-stock', $fish) }}" method="POST" class="mt-6">
                    @csrf
                    <label for="quantity" class="form-label">Add Stock (kg)</label>
                    <div class="flex gap-3">
                        <input type="number" id="quantity" name="quantity" step="0.01" min="0.01" class="form-input" placeholder="0.00" required>
                        <button type="submit" class="btn btn-success" style="min-width: 80px;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Status Card -->
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-sm text-gray-600">Stock Status:</span>
                        <div class="mt-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $fish->quantity_available > 5 ? 'bg-green-100 text-green-800' : ($fish->quantity_available > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $fish->quantity_available > 5 ? 'In Stock' : ($fish->quantity_available > 0 ? 'Low Stock' : 'Out of Stock') }}
                            </span>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <span class="text-sm text-gray-600">Created:</span>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $fish->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <span class="text-sm text-gray-600">Last Updated:</span>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $fish->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 space-y-3">
                    @if($fish->quantity_available > 0)
                        <a href="{{ route('sales.create', ['fish_id' => $fish->id]) }}" class="btn btn-success w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            Record Sale
                        </a>
                    @endif
                    <form action="{{ route('fish.destroy', $fish) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fish?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Fish
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales History -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-xl font-semibold text-gray-900">Sales History</h3>
        </div>
        @if($salesHistory->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">Date</th>
                            <th class="table-header-cell">Customer</th>
                            <th class="table-header-cell">Quantity Sold</th>
                            <th class="table-header-cell">Price/kg</th>
                            <th class="table-header-cell">Total</th>
                            <th class="table-header-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach($salesHistory as $sale)
                            <tr>
                                <td class="table-cell">
                                    <div class="font-medium">{{ $sale->sale_date->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $sale->sale_date->format('h:i A') }}</div>
                                </td>
                                <td class="table-cell">{{ $sale->customer_name ?: 'Walk-in Customer' }}</td>
                                <td class="table-cell">{{ number_format($sale->quantity_sold, 2) }} kg</td>
                                <td class="table-cell">₱{{ number_format($sale->price_per_kilo, 2) }}</td>
                                <td class="table-cell font-medium text-green-600">₱{{ number_format($sale->total_price, 2) }}</td>
                                <td class="table-cell">
                                    <div class="flex gap-3">
                                        <a href="{{ route('sales.show', $sale) }}" class="text-ocean-600 hover:text-ocean-900 text-sm">
                                            View
                                        </a>
                                        <a href="{{ route('sales.edit', $sale) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer">
                {{ $salesHistory->links() }}
            </div>
        @else
            <div class="card-body text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No sales recorded</h3>
                <p class="mt-1 text-sm text-gray-500">This fish hasn't been sold yet.</p>
            </div>
        @endif
    </div>
</div>
<!-- Close main fish details card -->
@endsection
