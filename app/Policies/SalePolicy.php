<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;

class SalePolicy
{
    public function view(User $user, Sale $sale)
    {
        return $user->id === $sale->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Sale $sale)
    {
        return $user->id === $sale->user_id;
    }

    public function delete(User $user, Sale $sale)
    {
        return $user->id === $sale->user_id;
    }
}
