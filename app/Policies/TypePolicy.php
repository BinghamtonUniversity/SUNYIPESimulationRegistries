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
            ->where('permission','read')
            ->orWhere('permission','write')
            ->orWhere('permission','admin')
            ->exists();
    }

    public function update(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','admin')
            ->exists();
    }
    /**
     * Determine whether the user can manage types.
     */
    public function manage(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','admin')
            ->exists();
    }
}
