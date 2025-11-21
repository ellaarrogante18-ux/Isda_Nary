<?php

namespace App\Policies;

use App\Models\Fish;
use App\Models\User;

class FishPolicy
{
    public function view(User $user, Fish $fish)
    {
        return $user->id === $fish->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Fish $fish)
    {
        return $user->id === $fish->user_id;
    }

    public function delete(User $user, Fish $fish)
    {
        return $user->id === $fish->user_id;
    }
}
