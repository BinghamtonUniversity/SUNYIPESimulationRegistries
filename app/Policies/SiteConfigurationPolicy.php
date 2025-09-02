<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\SiteConfiguration;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SiteConfigurationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function manage(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','admin')->exists();
    }
}
