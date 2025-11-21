@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')
<!-- Main Expense Details Card -->
<div class="bg-white rounded-xl shadow-xl p-8 max-w-4xl mx-auto">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Expense Details</h1>
            <p class="text-xl text-gray-600">View complete expense information</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Expense Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-xl font-semibold text-gray-900">Expense Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Expense ID:</label>
                    <p class="text-base font-medium text-gray-900 mt-1">#{{ str_pad($expense->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Expense Date:</label>
                    <p class="text-base font-medium text-gray-900 mt-1">{{ $expense->expense_date->format('F d, Y') }}</p>
                    <p class="text-sm text-gray-500">{{ $expense->expense_date->diffForHumans() }}</p>
                </div>

                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Category:</label>
                    <div class="mt-2">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                            {{ \App\Models\Expense::getCategories()[$expense->category] ?? $expense->category }}
                        </span>
                    </div>
                </div>

                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Description:</label>
                    <p class="text-base font-medium text-gray-900 mt-1">{{ $expense->description }}</p>
                </div>

                @if($expense->notes)
                <div class="pb-3 border-b border-gray-200">
                    <label class="text-sm text-gray-600">Notes:</label>
                    <p class="text-base text-gray-900 mt-1">{{ $expense->notes }}</p>
                </div>
                @endif

                <div>
                    <label class="text-sm text-gray-600">Record Created:</label>
                    <p class="text-sm text-gray-500 mt-1">{{ $expense->created_at->format('M d, Y h:i A') }}</p>
                </div>

                @if($expense->updated_at != $expense->created_at)
                <div>
                    <label class="text-sm text-gray-600">Last Updated:</label>
                    <p class="text-sm text-gray-500 mt-1">{{ $expense->updated_at->format('M d, Y h:i A') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Amount and Receipt -->
        <div class="space-y-6">
            <!-- Amount Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-xl font-semibold text-gray-900">Amount</h3>
                </div>
                <div class="card-body">
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 p-6 rounded-lg border-2 border-red-200">
                        <label class="text-sm text-gray-600">Total Expense:</label>
                        <p class="text-4xl font-bold text-red-600 mt-2">₱{{ number_format($expense->amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Receipt Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-xl font-semibold text-gray-900">Receipt</h3>
                </div>
                <div class="card-body">
                    @if($expense->receipt_image)
                        <div class="space-y-3">
                            <img src="{{ asset('storage/' . $expense->receipt_image) }}" alt="Receipt" class="w-full rounded-lg border-2 border-gray-200">
                            <a href="{{ asset('storage/' . $expense->receipt_image) }}" target="_blank" class="btn btn-secondary w-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Full Receipt
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No receipt image attached</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-3 mt-6">
        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Expense
        </a>
        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete Expense
            </button>
        </form>
    </div>
</div>
<!-- Close main expense details card -->
@endsection
