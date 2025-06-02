<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission',"manage_users")
            ->orWhere('permission','view_users')
            ->orWhere('permission','manage_permissions')
            ->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission',"manage_users")
            ->orWhere('permission','view_users')
            ->orWhere('permission','manage_permissions')
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Permission::where('user_id',$user->id)->where('permission',"manage_users")->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return Permission::where('user_id',$user->id)->where('permission',"manage_users")->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user):bool
    {
        return Permission::where('user_id',$user->id)->where('permission',"manage_users")->exists();
    }

    public function manage_user_permissions(User $user):bool {
        return Permission::where('user_id',$user->id)->where('permission','manage_permissions')->exists();
    }
}
