<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityValue;

class PagesController extends Controller
{
    public function __construct() {
    }

    public function home(){
        return view('pages.home',[
            'title'=>'Home'
        ]);
    }

    public function search(){
        return view('pages.search',[
            'title'=>'Search',
            'data'=>[
                'search_form'=>[
                    'name' => 'Search',
                    'fields' => Activity::get_search_form_fields(),
                    'actions' => [
                        ['type' => 'save','action' => 'save','label' => 'Search','modifiers' => 'btn btn-info']
                    ],
                ]
            ]
        ]);
    }

    public function search_results(Request $request){
        if (!$request->has('types')) {
            return view('pages.search_results',['error'=>'You must specify at least one type!','activities'=>[]]);
        }
        $activity_ids = Activity::select('id')->where(function($q) use ($request) {
            if ($request->is_ipe === true) {
                $q->orWhere('is_ipe',true);
            }
            if ($request->is_simulation === true) {
                $q->orWhere('is_simulation',true);
            }
        })->where('status','approved')->get()->pluck('id');

        $activity_values = ActivityValue::select('activity_id','value_id')
            ->whereIn('activity_id',$activity_ids)
            ->where(function($q) use ($request) {
                foreach($request->types as $type => $values) {
                    foreach($values as $value) {
                        $value_id = Str::of($value)->ltrim('value_');
                        $q->orWhere('value_id',$value_id);
                    }
                }
            })->with('value')->get();
        // return $activity_values;

        $ranked_activity_ids = [];
        foreach($activity_values as $activity_value) {
            if (!isset($ranked_activity_ids[$activity_value->activity_id])) {
                $ranked_activity_ids[$activity_value->activity_id] = [
                    'count' => 0, 'id' => $activity_value->activity_id,'values' => []
                ];
            }
            $ranked_activity_ids[$activity_value->activity_id]['count']++;
            $ranked_activity_ids[$activity_value->activity_id]['values'][] = $activity_value->value->value;
        }
        $ranked_activity_ids = collect($ranked_activity_ids)->sortBy('count')->reverse();
        $activities = Activity::whereIn('id',$ranked_activity_ids->pluck('id'))
            ->where(function($q) use ($request) {
                if ($request->is_ipe === true) {
                    $q->orWhere('is_ipe',true);
                }
                if ($request->is_simulation === true) {
                    $q->orWhere('is_simulation',true);
                }
            })->where('status','approved')->get()
            ->map(function($activity) use ($ranked_activity_ids) {
                $activity->count = $ranked_activity_ids[$activity->id]['count'];
                $activity->matches = $ranked_activity_ids[$activity->id]['values'];
                return $activity;
            })->sortBy('count')->reverse()->values();

        return view('pages.search_results',[
            'title'=>'Search Results',
            'activities' => $activities,
        ]);
    }

    public function activity(Request $request, Activity $activity){
        return view('pages.activity',[
            'activity'=>$activity->withPlainTextValues()
        ]);
    }
    public function manage(Request $request){
        if (Auth::check()) {
            return view('pages.manage',[
                'activities_form_fields'=>Activity::get_form_fields(),
            ]);
        } else {
            return redirect(url('/manage/login'));
        }
    }

//    public function log_out(Request $request){
//        if (Auth::check()) {
//            Auth::logout();
//            return redirect(url('/'));
//        } else {
//            return redirect(url('/manage/login'));
//        }
//    }
}
