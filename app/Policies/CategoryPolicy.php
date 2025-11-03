<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user): bool { return false; }
    public function delete(User $user): bool { return false; }
}
