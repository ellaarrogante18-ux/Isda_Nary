<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get today's data
        $todaySales = Sale::where('user_id', $user->id)->today()->sum('total_price');
        $todayExpenses = Expense::where('user_id', $user->id)->today()->sum('amount');
        $todayProfit = $todaySales - $todayExpenses;
        
        // Get this month's data
        $monthSales = Sale::where('user_id', $user->id)->thisMonth()->sum('total_price');
        $monthExpenses = Expense::where('user_id', $user->id)->thisMonth()->sum('amount');
        $monthProfit = $monthSales - $monthExpenses;
        
        // Get inventory stats
        $totalFishTypes = Fish::where('user_id', $user->id)->count();
        $totalStock = Fish::where('user_id', $user->id)->sum('quantity_available');
        $lowStockItems = Fish::where('user_id', $user->id)
                            ->where('quantity_available', '<', 5)
                            ->count();
        
        // Recent sales
        $recentSales = Sale::where('user_id', $user->id)
                          ->with('fish')
                          ->orderBy('sale_date', 'desc')
                          ->limit(5)
                          ->get();
        
        // Top selling fish this month
        $topSellingFish = Sale::where('user_id', $user->id)
                             ->thisMonth()
                             ->with('fish')
                             ->selectRaw('fish_id, SUM(quantity_sold) as total_sold, SUM(total_price) as total_revenue')
                             ->groupBy('fish_id')
                             ->orderBy('total_sold', 'desc')
                             ->limit(5)
                             ->get();
        
        // Weekly sales chart data
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Sale::where('user_id', $user->id)
                        ->whereDate('sale_date', $date)
                        ->sum('total_price');
            $weeklyData[] = [
                'date' => $date->format('M d'),
                'sales' => $sales
            ];
        }
        
        return view('dashboard', compact(
            'todaySales', 'todayExpenses', 'todayProfit',
            'monthSales', 'monthExpenses', 'monthProfit',
            'totalFishTypes', 'totalStock', 'lowStockItems',
            'recentSales', 'topSellingFish', 'weeklyData'
        ));
    }
}
