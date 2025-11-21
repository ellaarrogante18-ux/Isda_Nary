@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<!-- Main Add Fish Card -->
<div class="bg-white rounded-xl shadow-xl p-8 max-w-4xl mx-auto">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Add New Product</h1>
            <p class="text-xl text-gray-600">Add a new fish type to your inventory</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('fish.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Inventory
            </a>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('fish.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body space-y-6">
                <!-- Fish Name -->
                <div>
                    <label for="name" class="form-label">Fish Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fish Type -->
                <div>
                    <label for="type" class="form-label">Fish Type *</label>
                    <input type="text" id="type" name="type" value="{{ old('type') }}" class="form-input" placeholder="e.g., Saltwater, Freshwater, etc." required>
                    @error('type')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity and Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="quantity_available" class="form-label">Initial Quantity (kg) *</label>
                        <input type="number" id="quantity_available" name="quantity_available" value="{{ old('quantity_available') }}" step="0.01" min="0" class="form-input" required>
                        @error('quantity_available')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price_per_kilo" class="form-label">Price per Kilo (₱) *</label>
                        <input type="number" id="price_per_kilo" name="price_per_kilo" value="{{ old('price_per_kilo') }}" step="0.01" min="0" class="form-input currency-input" required>
                        @error('price_per_kilo')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3" class="form-input" placeholder="Optional description about the fish">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="form-label">Fish Image</label>
                    <input type="file" id="image" name="image" accept="image/*" class="form-input">
                    <p class="mt-1 text-sm text-gray-500">Upload an image of the fish (optional). Max size: 2MB</p>
                    @error('image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Value Display -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Total Inventory Value:</span>
                        <span id="total_value" class="text-lg font-bold text-green-600">₱0.00</span>
                    </div>
                </div>
            </div>

            <div class="card-footer flex justify-between">
                <a href="{{ route('fish.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Fish
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Close main add fish card -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity_available');
    const priceInput = document.getElementById('price_per_kilo');
    const totalValueElement = document.getElementById('total_value');

    function updateTotalValue() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = quantity * price;
        totalValueElement.textContent = '₱' + total.toFixed(2);
    }

    quantityInput.addEventListener('input', updateTotalValue);
    priceInput.addEventListener('input', updateTotalValue);
});
</script>
@endsection
