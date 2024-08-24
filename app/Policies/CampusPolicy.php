<?php

namespace App\Policies;

use App\Models\Campus;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function manage(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','manage_campuses')->exists();
    }
}
