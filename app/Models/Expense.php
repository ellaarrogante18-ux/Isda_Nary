<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'description',
        'amount',
        'expense_date',
        'notes',
        'receipt_image',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('expense_date', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('expense_date', now()->month)
                    ->whereYear('expense_date', now()->year);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('expense_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public static function getCategories()
    {
        return [
            'fuel' => 'Fuel & Transportation',
            'ice' => 'Ice & Preservation',
            'equipment' => 'Equipment & Tools',
            'maintenance' => 'Maintenance & Repairs',
            'supplies' => 'Supplies & Materials',
            'labor' => 'Labor & Wages',
            'utilities' => 'Utilities',
            'other' => 'Other Expenses'
        ];
    }
}
