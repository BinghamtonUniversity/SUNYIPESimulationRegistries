<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\DataType;
use App\Models\Participant;
use App\Models\Permission;
use App\Models\Report;
use App\Models\Study;
use App\Models\StudyDataType;
use App\Models\StudyParticipant;
use App\Models\StudyUser;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct() {
    }

    public function admin(Request $request) {
        $user = User::where('id',1)->first();
        Auth::login($user);
        $user_actions[] = ["name"=>"create","label"=>"Create User"];
        $user_actions[] = ["name"=>"edit","label"=>"Update User","min"=>1,"max"=>1];

        $user_actions[] = [""];
        $user_actions[] = [""];
        $user_actions[] = ["name"=>"delete","label"=>"Delete User","min"=>1,"max"=>1];
        $user_actions[] = ["name"=>"edit_permissions","label"=>"Update Permissions","min"=>1,"max"=>1];



        return view('admin.admin',[
            'page'=>'users',
            'title'=>'Manage Users',
            'actions'=>$user_actions,
//            'permissions'=>$auth_user_perms,
            'help'=>'Use this page to create, search for, view, delete, and modify existing users.'
        ]);
    }

    /* Users Tab */
    public function users(Request $request, User $user=null) {
//        $user = Auth::user();
        $user_actions[] = ["name"=>"create","label"=>"Create User"];
        $user_actions[] = ["name"=>"edit","label"=>"Update User","min"=>1,"max"=>1];
        $user_actions[] = ["name"=>"activate_user","label"=>"Activate User",'type'=>'success',"min"=>1,"max"=>5];
        $user_actions[] = ["name"=>"deactivate_user","label"=>"Deactivate User",'type'=>'danger',"min"=>1,"max"=>5];
        $user_actions[] = [""];
        $user_actions[] = [""];
        $user_actions[] = ["name"=>"delete","label"=>"Delete User","min"=>1,"max"=>1]; //may remove max



        return view('admin.admin',[
            'page'=>'users',
            'title'=>'Manage Users',
            'actions'=>$user_actions,
//            'permissions'=>$auth_user_perms,
            'help'=>'Use this page to create, search for, view, delete, and modify existing users.'
        ]);
    }
}
