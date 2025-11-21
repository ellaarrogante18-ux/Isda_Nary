<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Sale::where('user_id', Auth::id())
                    ->with('fish')
                    ->orderBy('sale_date', 'desc');

        // Handle period filters
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('sale_date', today());
                    break;
                case 'yesterday':
                    $query->whereDate('sale_date', today()->subDay());
                    break;
                case 'this_week':
                    $query->whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('sale_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('sale_date', now()->month)
                          ->whereYear('sale_date', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('sale_date', now()->subMonth()->month)
                          ->whereYear('sale_date', now()->subMonth()->year);
                    break;
            }
        }

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('customer_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('notes', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('fish', function($fishQuery) use ($searchTerm) {
                      $fishQuery->where('name', 'LIKE', "%{$searchTerm}%")
                               ->orWhere('type', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Handle custom date range
        if ($request->filled('date_from')) {
            $query->whereDate('sale_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('sale_date', '<=', $request->date_to);
        }

        if ($request->filled('fish_id')) {
            $query->where('fish_id', $request->fish_id);
        }

        $sales = $query->paginate(15);
        $fish = Fish::where('user_id', Auth::id())->get();
        
        $totalSales = $query->sum('total_price');
        $totalQuantity = $query->sum('quantity_sold');

        return view('sales.index', compact('sales', 'fish', 'totalSales', 'totalQuantity'));
    }

    public function create()
    {
        $fish = Fish::where('user_id', Auth::id())
                   ->where('quantity_available', '>', 0)
                   ->get();
        
        return view('sales.create', compact('fish'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fish_id' => 'required|exists:fish,id',
            'quantity_sold' => 'required|numeric|min:0.01',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'sale_date' => 'required|date'
        ]);

        $fish = Fish::findOrFail($validated['fish_id']);
        
        // Check if fish belongs to current user
        if ($fish->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if enough stock is available
        if ($fish->quantity_available < $validated['quantity_sold']) {
            return redirect()->back()
                           ->withErrors(['quantity_sold' => 'Not enough stock available. Available: ' . $fish->quantity_available . ' kg'])
                           ->withInput();
        }

        DB::transaction(function () use ($validated, $fish) {
            // Create sale record
            Sale::create([
                'user_id' => Auth::id(),
                'fish_id' => $validated['fish_id'],
                'quantity_sold' => $validated['quantity_sold'],
                'price_per_kilo' => $fish->price_per_kilo,
                'total_price' => $validated['quantity_sold'] * $fish->price_per_kilo,
                'customer_name' => $validated['customer_name'],
                'notes' => $validated['notes'],
                'sale_date' => $validated['sale_date']
            ]);

            // Update fish stock
            $fish->decrement('quantity_available', $validated['quantity_sold']);
        });

        return redirect()->route('sales.index')
                        ->with('success', 'Sale recorded successfully!');
    }

    public function show(Sale $sale)
    {
        $this->authorize('view', $sale);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $this->authorize('update', $sale);
        $fish = Fish::where('user_id', Auth::id())->get();
        return view('sales.edit', compact('sale', 'fish'));
    }

    public function update(Request $request, Sale $sale)
    {
        $this->authorize('update', $sale);

        $validated = $request->validate([
            'fish_id' => 'required|exists:fish,id',
            'quantity_sold' => 'required|numeric|min:0.01',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'sale_date' => 'required|date'
        ]);

        $fish = Fish::findOrFail($validated['fish_id']);
        
        if ($fish->user_id !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($validated, $fish, $sale) {
            // Restore previous stock
            $oldFish = Fish::findOrFail($sale->fish_id);
            $oldFish->increment('quantity_available', $sale->quantity_sold);

            // Check new stock availability
            if ($fish->quantity_available < $validated['quantity_sold']) {
                throw new \Exception('Not enough stock available. Available: ' . $fish->quantity_available . ' kg');
            }

            // Update sale record
            $sale->update([
                'fish_id' => $validated['fish_id'],
                'quantity_sold' => $validated['quantity_sold'],
                'price_per_kilo' => $fish->price_per_kilo,
                'total_price' => $validated['quantity_sold'] * $fish->price_per_kilo,
                'customer_name' => $validated['customer_name'],
                'notes' => $validated['notes'],
                'sale_date' => $validated['sale_date']
            ]);

            // Update new fish stock
            $fish->decrement('quantity_available', $validated['quantity_sold']);
        });

        return redirect()->route('sales.index')
                        ->with('success', 'Sale updated successfully!');
    }

    public function destroy(Sale $sale)
    {
        $this->authorize('delete', $sale);

        DB::transaction(function () use ($sale) {
            // Restore stock
            $fish = Fish::findOrFail($sale->fish_id);
            $fish->increment('quantity_available', $sale->quantity_sold);

            // Delete sale
            $sale->delete();
        });

        return redirect()->route('sales.index')
                        ->with('success', 'Sale deleted successfully!');
    }

    public function getFishPrice(Fish $fish)
    {
        if ($fish->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json([
            'price_per_kilo' => $fish->price_per_kilo,
            'available_stock' => $fish->quantity_available
        ]);
    }
}
