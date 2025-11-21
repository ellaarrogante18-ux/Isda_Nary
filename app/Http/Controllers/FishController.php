<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FishController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Fish::where('user_id', Auth::id());

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('type', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Handle stock status filter
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('quantity_available', '>', 5);
                    break;
                case 'low_stock':
                    $query->where('quantity_available', '>', 0)
                          ->where('quantity_available', '<=', 5);
                    break;
                case 'out_of_stock':
                    $query->where('quantity_available', '<=', 0);
                    break;
            }
        }

        $fish = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('fish.index', compact('fish'));
    }

    public function create()
    {
        return view('fish.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity_available' => 'required|numeric|min:0',
            'price_per_kilo' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('fish-images', 'public');
        }

        Fish::create($validated);

        return redirect()->route('fish.index')
                        ->with('success', 'Fish added successfully!');
    }

    public function show(Fish $fish)
    {
        $this->authorize('view', $fish);
        
        $salesHistory = $fish->sales()
                            ->orderBy('sale_date', 'desc')
                            ->paginate(10);
        
        return view('fish.show', compact('fish', 'salesHistory'));
    }

    public function edit(Fish $fish)
    {
        $this->authorize('update', $fish);
        return view('fish.edit', compact('fish'));
    }

    public function update(Request $request, Fish $fish)
    {
        $this->authorize('update', $fish);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity_available' => 'required|numeric|min:0',
            'price_per_kilo' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($fish->image) {
                Storage::disk('public')->delete($fish->image);
            }
            $validated['image'] = $request->file('image')->store('fish-images', 'public');
        }

        $fish->update($validated);

        return redirect()->route('fish.index')
                        ->with('success', 'Fish updated successfully!');
    }

    public function destroy(Fish $fish)
    {
        $this->authorize('delete', $fish);

        if ($fish->image) {
            Storage::disk('public')->delete($fish->image);
        }

        $fish->delete();

        return redirect()->route('fish.index')
                        ->with('success', 'Fish deleted successfully!');
    }

    public function addStock(Request $request, Fish $fish)
    {
        $this->authorize('update', $fish);

        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0.01'
        ]);

        $fish->increment('quantity_available', $validated['quantity']);

        return redirect()->back()
                        ->with('success', 'Stock added successfully!');
    }
}
