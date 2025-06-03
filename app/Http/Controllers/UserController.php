<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return User::get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User($request->all());
        $user->save();

        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return 1;
    }

    public function search($search_string='') {
        $search_elements_parsed = preg_split('/[\s,]+/',strtolower($search_string));
        $search = []; $users = []; $ids = collect();
        if (count($search_elements_parsed) === 1 && $search_elements_parsed[0]!='') {
            $search[0] = $search_elements_parsed[0];
            $ids = $ids->merge(DB::table('users')->select('id')
                ->orWhere('id',$search[0])->limit(15)->get()->pluck('id'));
            $ids = $ids->merge(DB::table('users')->select('id')
                ->orWhere('first_name','like',$search[0].'%')
                ->orWhere('last_name','like',$search[0].'%')->get()->pluck('id'));
            $ids = $ids->merge(DB::table('users')->select('id')
                ->orWhere('email',$search[0])->limit(15)->get()->pluck('id'));

            $users = User::select('id','first_name','last_name','email')
                ->whereIn('id',$ids)->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')
                ->limit(15)->get()->toArray();
        } else if (count($search_elements_parsed) > 1) {
            $search[0] = $search_elements_parsed[0];
            $search[1] = $search_elements_parsed[count($search_elements_parsed)-1];
            $ids = $ids->merge(DB::table('users')->select('id')
                ->where('first_name','like',$search[0].'%')->where('last_name','like',$search[1].'%')
                ->limit(15)->get()->pluck('id'));
            $ids = $ids->merge(DB::table('users')->select('id')
                ->where('first_name','like',$search[1].'%')->where('last_name','like',$search[0].'%')
                ->limit(15)->get()->pluck('id'));
            $users = User::select('id','first_name','last_name','email')
                ->whereIn('id',$ids)->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')
                ->limit(15)->get()->toArray();
        }
        foreach($users as $index => $user) {
            $users[$index] = array_intersect_key($user, array_flip(['id','first_name','last_name','email']));
        }
        return $users;
    }

    public function update_permissions(Request $request, User $user) {
        $request = $request->all();

        Permission::where('user_id',$user->id)->delete();
        foreach($request['permissions'] as $permission) {
            $permission = new Permission([
                'user_id'=>$user->id,
                'permission'=>$permission
            ]);
            $permission->save();
        }
        return Permission::where('user_id',$user->id)->get();
    }

    public function get_user_activites(Request $request, User $user) {
        $activities =  Activity::where('submitter_id',$user->id)->get();
        foreach ($activities as $activity) {
            $activity->withValuesModified();
        }
        return $activities;
    }
}
