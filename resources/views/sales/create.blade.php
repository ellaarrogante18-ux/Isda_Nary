@extends('layouts.app')

@section('title', 'Record New Sale')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Record New Sale</h1>
        <p class="text-gray-600">Record a fish sale transaction</p>
    </div>

    <div class="card">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            
            <div class="card-body space-y-6">
                <!-- Fish Selection -->
                <div>
                    <label for="fish_id" class="form-label">Select Fish *</label>
                    <select id="fish_id" name="fish_id" class="form-input" required onchange="getFishPrice(this.value)">
                        <option value="">Choose a fish...</option>
                        @foreach($fish as $fishItem)
                            <option value="{{ $fishItem->id }}" {{ request('fish_id') == $fishItem->id ? 'selected' : '' }}>
                                {{ $fishItem->name }} ({{ $fishItem->type }}) - Available: {{ $fishItem->quantity_available }}kg
                            </option>
                        @endforeach
                    </select>
                    <div id="stock_info" class="mt-1 text-sm"></div>
                    @error('fish_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="quantity_preset" class="form-label">Quick Quantity Selection</label>
                        <select id="quantity_preset" name="quantity_preset" class="form-input" onchange="setQuantityFromDropdown(this.value)">
                            <option value="">Select preset quantity...</option>
                            <option value="0.25">1/4 kg (0.25)</option>
                            <option value="0.5">1/2 kg (0.5)</option>
                            <option value="0.75">3/4 kg (0.75)</option>
                            <option value="1">1 kg</option>
                            <option value="1.25">1 1/4 kg (1.25)</option>
                            <option value="1.5">1 1/2 kg (1.5)</option>
                            <option value="1.75">1 3/4 kg (1.75)</option>
                            <option value="2">2 kg</option>
                            <option value="2.5">2 1/2 kg (2.5)</option>
                            <option value="3">3 kg</option>
                            <option value="4">4 kg</option>
                            <option value="5">5 kg</option>
                            <option value="custom">Custom Amount</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Choose a common quantity or select custom</p>
                    </div>

                    <div>
                        <label for="quantity_sold" class="form-label">Quantity (kg) *</label>
                        <input type="number" id="quantity_sold" name="quantity_sold" value="{{ old('quantity_sold') }}" step="0.01" min="0.01" class="form-input" required onchange="calculateTotal()" placeholder="Enter quantity in kg">
                        @error('quantity_sold')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Price Display -->
                <div>
                    <label for="price_per_kilo" class="form-label">Price per Kilo (₱)</label>
                    <input type="number" id="price_per_kilo" name="price_per_kilo" step="0.01" min="0" class="form-input bg-gray-50" readonly>
                    <p class="mt-1 text-sm text-gray-500">Auto-filled from product price</p>
                </div>

                <!-- Discount Section -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Discount Options</h4>
                    
                    <div class="space-y-4">
                        <!-- Discount Toggle -->
                        <div class="flex items-center">
                            <input type="checkbox" id="has_discount" name="has_discount" value="1" class="form-checkbox" onchange="toggleDiscount()">
                            <label for="has_discount" class="ml-2 text-sm font-medium text-gray-700">Apply discount to this sale</label>
                        </div>
                        
                        <!-- Discount Fields (Hidden by default) -->
                        <div id="discount_fields" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select id="discount_type" name="discount_type" class="form-input" onchange="calculateTotal()">
                                        <option value="percentage">Percentage (%)</option>
                                        <option value="fixed">Fixed Amount (₱)</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="discount_value" class="form-label">Discount Value</label>
                                    <input type="number" id="discount_value" name="discount_value" step="0.01" min="0" class="form-input" onchange="calculateTotal()">
                                </div>
                            </div>
                            
                            <div>
                                <label for="discount_reason" class="form-label">Discount Reason (Optional)</label>
                                <input type="text" id="discount_reason" name="discount_reason" placeholder="e.g., Regular customer, Bulk purchase, etc." class="form-input">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div>
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" class="form-input" placeholder="Optional - leave blank for walk-in customer">
                    @error('customer_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Date -->
                <div>
                    <label for="sale_date" class="form-label">Sale Date & Time *</label>
                    <input type="datetime-local" id="sale_date" name="sale_date" value="{{ old('sale_date', now()->format('Y-m-d\TH:i')) }}" class="form-input" required>
                    @error('sale_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Optional notes about this sale">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Price Display -->
                <div class="bg-teal-50 border border-teal-200 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Subtotal:</span>
                            <span id="subtotal" class="text-sm font-medium">₱0.00</span>
                        </div>
                        <div id="discount_display" class="hidden flex justify-between items-center text-red-600">
                            <span class="text-sm">Discount:</span>
                            <span id="discount_amount" class="text-sm font-medium">-₱0.00</span>
                        </div>
                        <hr class="border-teal-300">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-700">Total Amount:</span>
                            <span id="total_price" class="text-2xl font-bold text-teal-600">₱0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body border-t border-gray-200 flex justify-between">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Record Sale
                </button>
            </div>
        </form>
    </div>
</div>

@if($fish->count() == 0)
<div class="max-w-2xl mx-auto mt-6">
    <div class="alert alert-warning">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <p class="font-medium">No fish available for sale</p>
                <p class="text-sm mt-1">You need to add fish to your inventory before you can record sales.</p>
                <a href="{{ route('fish.create') }}" class="mt-2 inline-block text-sm font-medium text-yellow-800 hover:text-yellow-900">
                    Add Fish to Inventory →
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<script>
// Set quantity from dropdown selection
function setQuantityFromDropdown(value) {
    const quantityInput = document.getElementById('quantity_sold');
    
    if (value === 'custom') {
        // Clear the input and focus on it for custom entry
        quantityInput.value = '';
        quantityInput.focus();
        quantityInput.placeholder = 'Enter custom quantity...';
    } else if (value !== '') {
        // Set the preset value
        quantityInput.value = value;
        quantityInput.placeholder = 'Enter quantity in kg';
        calculateTotal();
    }
}

// Legacy function for backward compatibility (if needed elsewhere)
function setQuantity(amount) {
    document.getElementById('quantity_sold').value = amount;
    calculateTotal();
}

// Toggle discount fields
function toggleDiscount() {
    const checkbox = document.getElementById('has_discount');
    const discountFields = document.getElementById('discount_fields');
    const discountDisplay = document.getElementById('discount_display');
    
    if (checkbox.checked) {
        discountFields.classList.remove('hidden');
        discountDisplay.classList.remove('hidden');
    } else {
        discountFields.classList.add('hidden');
        discountDisplay.classList.add('hidden');
        // Clear discount values
        document.getElementById('discount_value').value = '';
        document.getElementById('discount_reason').value = '';
    }
    calculateTotal();
}

// Get fish price and update display
function getFishPrice(fishId) {
    if (fishId) {
        fetch(`/fish/${fishId}/price`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('price_per_kilo').value = data.price_per_kilo;
                document.getElementById('stock_info').innerHTML = 
                    `<span class="text-green-600">Available: ${data.quantity_available} kg</span>`;
                calculateTotal();
            })
            .catch(error => {
                console.error('Error fetching fish price:', error);
                document.getElementById('stock_info').innerHTML = 
                    '<span class="text-red-600">Error loading fish information</span>';
            });
    } else {
        document.getElementById('price_per_kilo').value = '';
        document.getElementById('stock_info').innerHTML = '';
        calculateTotal();
    }
}

// Calculate total with discount
function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantity_sold').value) || 0;
    const pricePerKilo = parseFloat(document.getElementById('price_per_kilo').value) || 0;
    const hasDiscount = document.getElementById('has_discount').checked;
    
    let subtotal = quantity * pricePerKilo;
    let discountAmount = 0;
    
    // Calculate discount
    if (hasDiscount) {
        const discountType = document.getElementById('discount_type').value;
        const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
        
        if (discountType === 'percentage') {
            discountAmount = (subtotal * discountValue) / 100;
        } else {
            discountAmount = discountValue;
        }
        
        // Ensure discount doesn't exceed subtotal
        discountAmount = Math.min(discountAmount, subtotal);
    }
    
    const total = subtotal - discountAmount;
    
    // Update display
    document.getElementById('subtotal').textContent = `₱${subtotal.toFixed(2)}`;
    document.getElementById('discount_amount').textContent = `-₱${discountAmount.toFixed(2)}`;
    document.getElementById('total_price').textContent = `₱${total.toFixed(2)}`;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Auto-select fish if fish_id is in URL
    const urlParams = new URLSearchParams(window.location.search);
    const fishId = urlParams.get('fish_id');
    if (fishId) {
        document.getElementById('fish_id').value = fishId;
        getFishPrice(fishId);
    }
    
    // Add event listener to quantity input to update dropdown when manually changed
    const quantityInput = document.getElementById('quantity_sold');
    const quantityDropdown = document.getElementById('quantity_preset');
    
    quantityInput.addEventListener('input', function() {
        const value = this.value;
        // Check if the entered value matches any dropdown option
        const matchingOption = Array.from(quantityDropdown.options).find(option => option.value === value);
        
        if (matchingOption) {
            quantityDropdown.value = value;
        } else if (value !== '') {
            quantityDropdown.value = 'custom';
        } else {
            quantityDropdown.value = '';
        }
    });
});
</script>

@endsection
