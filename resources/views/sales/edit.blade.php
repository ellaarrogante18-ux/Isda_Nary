@extends('layouts.app')

@section('title', 'Edit Sale')

@section('content')
<!-- Main Edit Sale Card -->
<div class="bg-white rounded-xl shadow-xl p-8 max-w-4xl mx-auto">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Edit Sale</h1>
            <p class="text-xl text-gray-600">Update sale record information</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Sales
            </a>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('sales.update', $sale) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body space-y-6">
                <!-- Fish Selection -->
                <div>
                    <label for="fish_id" class="form-label">Fish *</label>
                    <select id="fish_id" name="fish_id" class="form-input" required>
                        <option value="">Select a fish</option>
                        @foreach($fish as $fishItem)
                            <option value="{{ $fishItem->id }}" 
                                data-price="{{ $fishItem->price_per_kilo }}" 
                                data-stock="{{ $fishItem->quantity_available }}"
                                {{ old('fish_id', $sale->fish_id) == $fishItem->id ? 'selected' : '' }}>
                                {{ $fishItem->name }} - ₱{{ number_format($fishItem->price_per_kilo, 2) }}/kg ({{ number_format($fishItem->quantity_available, 2) }} kg available)
                            </option>
                        @endforeach
                    </select>
                    @error('fish_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Date -->
                <div>
                    <label for="sale_date" class="form-label">Sale Date *</label>
                    <input type="datetime-local" id="sale_date" name="sale_date" value="{{ old('sale_date', $sale->sale_date->format('Y-m-d\TH:i')) }}" class="form-input" required>
                    @error('sale_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity Sold -->
                <div>
                    <label for="quantity_sold" class="form-label">Quantity Sold (kg) *</label>
                    <input type="number" id="quantity_sold" name="quantity_sold" value="{{ old('quantity_sold', $sale->quantity_sold) }}" step="0.01" min="0.01" class="form-input" required>
                    <p class="mt-1 text-sm text-gray-500" id="stock_info">Available stock will be shown after selecting a fish</p>
                    @error('quantity_sold')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Name -->
                <div>
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $sale->customer_name) }}" class="form-input" placeholder="Optional - Leave blank for walk-in customers">
                    @error('customer_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Optional notes about this sale">{{ old('notes', $sale->notes) }}</textarea>
                    @error('notes')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Summary -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-3">Sale Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Price per Kilo:</span>
                            <span class="text-sm font-medium" id="price_display">₱{{ number_format($sale->price_per_kilo, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Quantity:</span>
                            <span class="text-sm font-medium" id="quantity_display">{{ number_format($sale->quantity_sold, 2) }} kg</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-300">
                            <span class="text-base font-semibold text-gray-900">Total Amount:</span>
                            <span class="text-lg font-bold text-green-600" id="total_display">₱{{ number_format($sale->total_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer flex justify-between">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Sale
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Close main edit sale card -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fishSelect = document.getElementById('fish_id');
    const quantityInput = document.getElementById('quantity_sold');
    const stockInfo = document.getElementById('stock_info');
    const priceDisplay = document.getElementById('price_display');
    const quantityDisplay = document.getElementById('quantity_display');
    const totalDisplay = document.getElementById('total_display');

    let currentPrice = {{ $sale->price_per_kilo }};
    let currentStock = 0;

    function updateStockInfo() {
        const selectedOption = fishSelect.options[fishSelect.selectedIndex];
        if (selectedOption.value) {
            currentPrice = parseFloat(selectedOption.dataset.price) || 0;
            currentStock = parseFloat(selectedOption.dataset.stock) || 0;
            stockInfo.textContent = `Available stock: ${currentStock.toFixed(2)} kg`;
            stockInfo.classList.remove('text-gray-500');
            stockInfo.classList.add('text-ocean-600');
        } else {
            stockInfo.textContent = 'Please select a fish first';
            stockInfo.classList.remove('text-ocean-600');
            stockInfo.classList.add('text-gray-500');
        }
        updateSummary();
    }

    function updateSummary() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const total = quantity * currentPrice;

        priceDisplay.textContent = '₱' + currentPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        quantityDisplay.textContent = quantity.toFixed(2) + ' kg';
        totalDisplay.textContent = '₱' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    fishSelect.addEventListener('change', updateStockInfo);
    quantityInput.addEventListener('input', updateSummary);

    // Initialize on page load
    updateStockInfo();
});
</script>
@endsection
