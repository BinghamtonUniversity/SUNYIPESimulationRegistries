<?php

namespace App\Http\Controllers;

use App\Models\IPE;
use App\Models\Simulation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;

class PagesController extends Controller
{
    public function __construct() {
        $user = User::where('id',1)->first();
        Auth::login($user);
    }

    public function home(){
        return view('pages.home',[
            'title'=>'Home'
        ]);
    }

    public function ipes(){
        $ipes = IPE::get();
        return view('pages.ipes',[
            'title'=>'IPEs',
            'ipes'=> $ipes
        ]);
    }

    public function ipe(Request $request, IPE $ipe){
        return view('pages.ipe',[
            'ipe'=>$ipe
        ]);
    }
    public function simulations(){
        $simulations = Simulation::get();

        return view('pages.simulations',[
            'title'=>'Simulations',
            'simulations'=> $simulations
        ]);
    }

    public function simulation(Request $request, Simulation $simulation){

        return view('pages.simulation',[
//            'title'=> $simulation->name,
            'simulation'=> $simulation
        ]);
    }
}
