<?php

namespace App\Providers;

use App\Models\Fish;
use App\Models\Sale;
use App\Models\Expense;
use App\Policies\FishPolicy;
use App\Policies\SalePolicy;
use App\Policies\ExpensePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Fish::class => FishPolicy::class,
        Sale::class => SalePolicy::class,
        Expense::class => ExpensePolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
