<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Type;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TypePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','view_types')
            ->orWhere('permission','manage_types')
            ->exists();
    }

    public function update(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','manage_types')
            ->exists();
    }
    /**
     * Determine whether the user can manage types.
     */
    public function manage(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','manage_types')
            ->exists();
    }
}
