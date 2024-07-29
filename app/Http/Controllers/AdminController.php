<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct() {
    }

    public function admin(Request $request) {
        $user_actions[] = ["name"=>"create","label"=>"Create User"];
        $user_actions[] = ["name"=>"edit","label"=>"Update User","min"=>1,"max"=>1];

        $user_actions[] = [""];
        $user_actions[] = [""];
        $user_actions[] = ["name"=>"delete","label"=>"Delete User","min"=>1,"max"=>1];
        $user_actions[] = ["name"=>"user_permissions","label"=>"Update Permissions","min"=>1,"max"=>1];

        return view('admin.admin',[
            'page'=>'users',
            'title'=>'Manage Users',
            'actions'=>$user_actions,
            'help'=>'Use this page to create, search for, view, delete, and modify existing users.'
        ]);
    }

    /* Users Tab */
    public function users(Request $request) {

        $user_actions[] = ["name"=>"create","label"=>"Create"];
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
            'help'=>'Use this page to create, search for, view, delete, and modify existing users.'
        ]);
    }

    public function activities(Request $request) {
        $user_actions[] = ["name"=>"create","label"=>"Create Activity"];
        $user_actions[] = ["name"=>"edit","label"=>"Update","min"=>1,"max"=>1];
        $user_actions[] = ["name"=>"view_logs","label"=>"View Logs","min"=>1,"max"=>1];

        return view('admin.admin',[
            'page'=>'activities',
            'title'=>'Manage Activities',
            'actions'=>$user_actions,
            'help'=>'Use this page to create, search for, view, delete, and modify existing Activities.'
        ]);
    }

    public function types(Request $request) {
        $user_actions[] = ["name"=>"create","label"=>"Create Type"];
        $user_actions[] = ["name"=>"edit","label"=>"Update","min"=>1,"max"=>1];
        $user_actions[] = ["name"=>"manage_values","label"=>"Values","min"=>1,"max"=>1];

        return view('admin.admin',[
            'page'=>'types',
            'title'=>'Manage Types',
            'actions'=>$user_actions,
            'help'=>'Use this page to create, search for, view, delete, and modify existing Types.'
        ]);
    }

    public function values(Request $request, Type $type) {
        $user_actions[] = ["name"=>"create","label"=>"Create Value"];
        $user_actions[] = ["name"=>"edit","label"=>"Update","min"=>1,"max"=>1];
//        dd($type);
        return view('admin.admin',[
            'page'=>'values',
            'title'=>'Manage Values of'.$type->type,
            'actions'=>$user_actions,
            "type_id"=>$type->id,
            'help'=>'Use this page to create, search for, view, delete, and modify existing Values.'
        ]);
    }
    public function campuses(Request $request) {
        $user_actions[] = ["name"=>"create","label"=>"Create Campuse"];
        $user_actions[] = ["name"=>"edit","label"=>"Update","min"=>1,"max"=>1];

        return view('admin.admin',[
            'page'=>'campuses',
            'title'=>'ManageCampuses',
            'actions'=>$user_actions,
            'help'=>'Use this page to create, search for, view, delete, and modify existing campuses.'
        ]);
    }

    public function site_configurations(Request $request) {
        $user_actions[] = ["name"=>"create","label"=>"Create Configuration"];
        $user_actions[] = ["name"=>"edit","label"=>"Update","min"=>1,"max"=>1];

        return view('admin.admin',[
            'page'=>'site_configurations',
            'title'=>'Manage Site Configurations',
            'actions'=>$user_actions,
            'help'=>'Use this page to create, search for, view, delete, and modify existing configurations.'
        ]);
    }
    public function activity_logs(Request $request, Activity $activity) {
        $user_actions[] = ["name"=>"create","label"=>"Create Value"];
        $user_actions[] = ["name"=>"edit","label"=>"Update","min"=>1,"max"=>1];
        return view('admin.admin',[
            'page'=>'activity_logs',
            'title'=>'Manage Values of'.$activity->title,
            'actions'=>$user_actions,
            "id"=>$activity->id,
            'help'=>'Use this page to create, search for, view, delete, and modify existing Values.'
        ]);
    }
}
