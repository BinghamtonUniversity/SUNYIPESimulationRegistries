<?php

namespace App\Http\Controllers;

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

        return view('admin.admin',[
            'page'=>'activities',
            'title'=>'Manage Activities',
            'actions'=>$user_actions,
            'help'=>'Use this page to create, search for, view, delete, and modify existing Activities.'
        ]);
    }

//    public function simulations(Request $request) {
//        $user_actions[] = ["name"=>"create","label"=>"Create Simulation"];
//        $user_actions[] = ["name"=>"edit","label"=>"Update","min"=>1,"max"=>1];
//
//        return view('admin.admin',[
//            'page'=>'simulations',
//            'title'=>'Manage Simulations',
//            'actions'=>$user_actions,
//            'help'=>'Use this page to create, search for, view, delete, and modify existing Simulations.'
//        ]);
//    }
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
}
