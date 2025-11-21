<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fish';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'quantity_available',
        'price_per_kilo',
        'description',
        'image',
    ];

    protected $casts = [
        'quantity_available' => 'decimal:2',
        'price_per_kilo' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function getTotalSoldAttribute()
    {
        return $this->sales()->sum('quantity_sold');
    }

    public function getTotalRevenueAttribute()
    {
        return $this->sales()->sum('total_price');
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity_available', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity_available', '<=', 0);
    }
}
