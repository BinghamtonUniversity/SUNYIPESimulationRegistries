<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;

class PagesController extends Controller
{
    public function __construct() {
    }

    public function home(){
        return view('pages.home',[
            'title'=>'Home'
        ]);
    }

    public function activities(){
        $activities = Activity::get();
        return view('pages.activities',[
            'title'=>'Activities',
            'activities'=> $activities
        ]);
    }

    public function activity(Request $request, Activity $activity){
        return view('pages.activity',[
            'activity'=>$activity
        ]);
    }
}
