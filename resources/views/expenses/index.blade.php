@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
<!-- Main Expenses Card -->
<div class="bg-white rounded-xl shadow-xl p-8">
    <div class="page-header">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Expenses</h1>
            <p class="text-xl text-gray-600">Track your daily business expenses</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Expense
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Expenses</h3>
            
            <!-- Quick Filter Buttons -->
            <div class="flex flex-wrap gap-2 mb-4">
                <a href="{{ route('expenses.index', ['period' => 'today']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'today' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Today
                </a>
                <a href="{{ route('expenses.index', ['period' => 'yesterday']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'yesterday' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Yesterday
                </a>
                <a href="{{ route('expenses.index', ['period' => 'this_week']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'this_week' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    This Week
                </a>
                <a href="{{ route('expenses.index', ['period' => 'last_week']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'last_week' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Last Week
                </a>
                <a href="{{ route('expenses.index', ['period' => 'this_month']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'this_month' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    This Month
                </a>
                <a href="{{ route('expenses.index', ['period' => 'last_month']) }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ request('period') == 'last_month' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Last Month
                </a>
                <a href="{{ route('expenses.index') }}" 
                   class="px-4 py-2 text-sm rounded-lg {{ !request('period') && !request('date_from') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Time
                </a>
            </div>

            <!-- Advanced Filters -->
            <form method="GET" action="{{ route('expenses.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="form-input">
                </div>
                <div>
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="form-input">
                </div>
                <div>
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category" class="form-input">
                        <option value="">All Categories</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    @if($totalExpenses > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="stat-label">Total Expenses</p>
                    <p class="stat-value">₱{{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="stat-label">Total Records</p>
                    <p class="stat-value">{{ $expenses->total() }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="stat-label">Avg. per Record</p>
                    <p class="stat-value">₱{{ $expenses->total() > 0 ? number_format($totalExpenses / $expenses->total(), 2) : '0.00' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Expenses Table -->
    @if($expenses->count() > 0)
        <div class="card">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">Date</th>
                            <th class="table-header-cell">Category</th>
                            <th class="table-header-cell">Description</th>
                            <th class="table-header-cell">Amount</th>
                            <th class="table-header-cell">Receipt</th>
                            <th class="table-header-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach($expenses as $expense)
                            <tr>
                                <td class="table-cell">
                                    <div class="font-medium">{{ $expense->expense_date->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $expense->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="table-cell">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ $categories[$expense->category] ?? $expense->category }}
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div>
                                        <div class="font-medium">{{ $expense->description }}</div>
                                        @if($expense->notes)
                                            <div class="text-sm text-gray-500">{{ Str::limit($expense->notes, 50) }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="table-cell font-medium text-red-600">
                                    ₱{{ number_format($expense->amount, 2) }}
                                </td>
                                <td class="table-cell">
                                    @if($expense->receipt_image)
                                        <a href="{{ asset('storage/' . $expense->receipt_image) }}" target="_blank" class="text-ocean-600 hover:text-ocean-900 text-sm">
                                            View Receipt
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">No receipt</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="flex gap-3">
                                        <a href="{{ route('expenses.show', $expense) }}" class="text-ocean-600 hover:text-ocean-900 text-sm">
                                            View
                                        </a>
                                        <a href="{{ route('expenses.edit', $expense) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Are you sure you want to delete this expense?')">
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
            {{ $expenses->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No expenses recorded</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by recording your first expense.</p>
            <div class="mt-6">
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Expense
                </a>
            </div>
        </div>
    @endif
</div>
<!-- Close main expenses card -->
</div>
@endsection
