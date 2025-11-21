@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')
<!-- Main Edit Expense Card -->
<div class="bg-white rounded-xl shadow-xl p-8 max-w-4xl mx-auto">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Edit Expense</h1>
            <p class="text-xl text-gray-600">Update expense record information</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Expenses
            </a>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('expenses.update', $expense) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="card-body space-y-6">
                <!-- Current Receipt Preview -->
                @if($expense->receipt_image)
                    <div>
                        <label class="form-label">Current Receipt</label>
                        <div class="flex items-start gap-4">
                            <img src="{{ asset('storage/' . $expense->receipt_image) }}" alt="Receipt" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Upload a new image to replace the current receipt</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Category -->
                <div>
                    <label for="category" class="form-label">Category *</label>
                    <select id="category" name="category" class="form-input" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category', $expense->category) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label">Description *</label>
                    <input type="text" id="description" name="description" value="{{ old('description', $expense->description) }}" class="form-input" placeholder="Brief description of the expense" required>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount and Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="amount" class="form-label">Amount (₱) *</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" step="0.01" min="0.01" class="form-input" required>
                        @error('amount')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expense_date" class="form-label">Expense Date *</label>
                        <input type="date" id="expense_date" name="expense_date" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" class="form-input" required>
                        @error('expense_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Additional notes or details about this expense">{{ old('notes', $expense->notes) }}</textarea>
                    @error('notes')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Receipt Image Upload -->
                <div>
                    <label for="receipt_image" class="form-label">Receipt Image</label>
                    <input type="file" id="receipt_image" name="receipt_image" accept="image/*" class="form-input">
                    <p class="mt-1 text-sm text-gray-500">Upload a new receipt image to replace the current one (optional). Max size: 2MB</p>
                    @error('receipt_image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount Preview -->
                <div class="bg-red-50 p-4 rounded-lg border-2 border-red-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Total Expense Amount:</span>
                        <span id="amount_display" class="text-2xl font-bold text-red-600">₱{{ number_format($expense->amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card-footer flex justify-between">
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Expense
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Close main edit expense card -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const amountDisplay = document.getElementById('amount_display');

    function updateAmountDisplay() {
        const amount = parseFloat(amountInput.value) || 0;
        amountDisplay.textContent = '₱' + amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    amountInput.addEventListener('input', updateAmountDisplay);
});
</script>
@endsection
