<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fish_id',
        'quantity_sold',
        'price_per_kilo',
        'total_price',
        'customer_name',
        'notes',
        'sale_date',
    ];

    protected $casts = [
        'quantity_sold' => 'decimal:2',
        'price_per_kilo' => 'decimal:2',
        'total_price' => 'decimal:2',
        'sale_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('sale_date', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('sale_date', now()->month)
                    ->whereYear('sale_date', now()->year);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('sale_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }
}
