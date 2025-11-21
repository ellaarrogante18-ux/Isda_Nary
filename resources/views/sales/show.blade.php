@extends('layouts.app')

@section('title', 'Sale Details')

@section('content')
<!-- Main Sale Details Card -->
<div class="bg-white rounded-xl shadow-xl p-8 max-w-4xl mx-auto">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Sale Details</h1>
            <p class="text-xl text-gray-600">View complete sale information</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
            <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sale Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-xl font-semibold text-gray-900">Sale Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Sale ID:</label>
                    <p class="text-base font-medium text-gray-900 mt-1">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Sale Date:</label>
                    <p class="text-base font-medium text-gray-900 mt-1">{{ $sale->sale_date->format('F d, Y') }}</p>
                    <p class="text-sm text-gray-500">{{ $sale->sale_date->format('h:i A') }}</p>
                </div>

                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Fish:</label>
                    <p class="text-base font-medium text-gray-900 mt-1">{{ $sale->fish->name }}</p>
                    <p class="text-sm text-gray-500">{{ $sale->fish->type }}</p>
                </div>

                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Customer:</label>
                    <p class="text-base font-medium text-gray-900 mt-1">{{ $sale->customer_name ?: 'Walk-in Customer' }}</p>
                </div>

                @if($sale->notes)
                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Notes:</label>
                    <p class="text-base text-gray-900 mt-1">{{ $sale->notes }}</p>
                </div>
                @endif

                <div>
                    <label class="text-sm text-gray-600">Record Created:</label>
                    <p class="text-sm text-gray-500 mt-1">{{ $sale->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Financial Details -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-xl font-semibold text-gray-900">Financial Details</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Quantity Sold:</label>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($sale->quantity_sold, 2) }} kg</p>
                </div>

                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Price per Kilogram:</label>
                    <p class="text-2xl font-bold text-green-600 mt-1">₱{{ number_format($sale->price_per_kilo, 2) }}</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-ocean-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600">Total Sale Amount:</label>
                    <p class="text-3xl font-bold text-green-600 mt-1">₱{{ number_format($sale->total_price, 2) }}</p>
                </div>

                <!-- Quick Calculation Display -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Calculation:</p>
                    <p class="text-sm font-mono text-gray-700">
                        {{ number_format($sale->quantity_sold, 2) }} kg × ₱{{ number_format($sale->price_per_kilo, 2) }} = ₱{{ number_format($sale->total_price, 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Fish Current Status -->
    <div class="card mt-6">
        <div class="card-header">
            <h3 class="text-xl font-semibold text-gray-900">Related Fish - Current Status</h3>
        </div>
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">{{ $sale->fish->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $sale->fish->type }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Current Stock:</p>
                    <p class="text-xl font-bold text-ocean-600">{{ number_format($sale->fish->quantity_available, 2) }} kg</p>
                    <a href="{{ route('fish.show', $sale->fish) }}" class="text-sm text-ocean-600 hover:text-ocean-900 mt-2 inline-block">
                        View Fish Details →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-3 mt-6">
        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Sale
        </a>
        <form action="{{ route('sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sale? This will restore the stock.');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete Sale
            </button>
        </form>
    </div>
</div>
<!-- Close main sale details card -->
@endsection
