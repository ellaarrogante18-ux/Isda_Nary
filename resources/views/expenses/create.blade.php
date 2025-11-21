@extends('layouts.app')

@section('title', 'Add New Expense')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Add New Expense</h1>
        <p class="text-gray-600">Record a business expense</p>
    </div>

    <div class="card">
        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body space-y-6">
                <!-- Category -->
                <div>
                    <label for="category" class="form-label">Category *</label>
                    <select id="category" name="category" class="form-input" required>
                        <option value="">Select a category...</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label">Description *</label>
                    <input type="text" id="description" name="description" value="{{ old('description') }}" class="form-input" placeholder="Brief description of the expense" required>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount and Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="amount" class="form-label">Amount (₱) *</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" class="form-input currency-input" required>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expense_date" class="form-label">Expense Date *</label>
                        <input type="date" id="expense_date" name="expense_date" value="{{ old('expense_date', now()->format('Y-m-d')) }}" class="form-input" required>
                        @error('expense_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="form-label">Additional Notes</label>
                    <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Optional additional details about this expense">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Receipt Upload -->
                <div>
                    <label for="receipt_image" class="form-label">Receipt Image</label>
                    <input type="file" id="receipt_image" name="receipt_image" accept="image/*" class="form-input">
                    <p class="mt-1 text-sm text-gray-500">Upload a photo of the receipt (optional). Max size: 2MB</p>
                    @error('receipt_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expense Summary -->
                <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-red-800">Expense Summary</p>
                            <p class="text-sm text-red-700">This expense will be deducted from your profit calculations.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body border-t border-gray-200 flex justify-between">
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Add Expense
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Expense Categories Info -->
    <div class="mt-6 card">
        <div class="card-header">
            <h3 class="text-lg font-medium text-gray-900">Expense Categories</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @foreach($categories as $key => $label)
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                        <span class="font-medium">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
