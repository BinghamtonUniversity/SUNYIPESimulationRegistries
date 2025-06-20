<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActivityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','view_activities')
            ->orWhere('permission','manage_activities')
            ->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Activity $activity): bool
    {
        return Permission::where('user_id',$user->id)
                ->where(function($query) use ($activity) {
                    $query->where('permission','manage_activities')
                        ->orWhere('permission','view_activities');
                })->exists()
            ||
            $activity->user == $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','manage_activities')
            ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activity $activity): bool
    {
        //
        return Permission::where('user_id',$user->id)
            ->where(function($query) use ($activity) {
                $query->where('permission','manage_activities')
                    ->orWhere('permission','view_activities');
            })->exists()
            ||
            $activity->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activity $activity): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','manage_activities')
            ->exists()
            ||
            $activity->user->id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','manage_activities')
            ->exists();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return Permission::where('user_id',$user->id)
            ->where('permission','manage_activities')
            ->exists();
    }

    public function viewLogs(User $user, Activity $activity): bool
    {
        return Permission::where('user_id',$user->id)
            ->where(function($query) use ($activity) {
                $query->where('permission','manage_activities')
                    ->orWhere('permission','view_activities');
            })
            ->exists()||
            $activity->user->id == $user->id;;
    }

}
