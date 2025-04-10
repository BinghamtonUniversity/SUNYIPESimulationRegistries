<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Cohensive\OEmbed\Facades\OEmbed;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityValue;
use App\Models\Type;
use App\Models\File;
use App\Models\SiteConfiguration;

class PagesController extends Controller
{
    public $site_config = [];

    public function __construct() {
        $this->site_config = SiteConfiguration::get()->mapWithKeys(function($value) {
            return [$value->key => $value->value];
        });
    }

    public function home(){
        return view('pages.home',[
            'title'=>'Home',
            'site_config' => $this->site_config
        ]);
    }

    public function browse(Request $request){
        $activity_ids = Activity::select('id')->where(function($q) use ($request) {
            if ($request->is_ipe == 'true') {
                $q->orWhere('is_ipe',true);
            }
            if ($request->is_simulation == 'true') {
                $q->orWhere('is_simulation',true);
            }
        })->where('status','approved')->get()->pluck('id');

        if (!$request->has('types')) {
            $activity_values = ActivityValue::select('activity_id','value_id')->with('value')->get();
        } else {
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
        }

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
            ->where('status','approved')->get()
            ->map(function($activity) use ($ranked_activity_ids) {
                $activity->count = $ranked_activity_ids[$activity->id]['count'];
                $activity->matches = $ranked_activity_ids[$activity->id]['values'];
                return $activity;
            })->sortBy('count')->reverse()->values();
        return view('pages.browse',[
            'title'=>'Search Results',
            'activities' => $activities,
            'data' => ['search_form_fields' => Activity::get_search_form_fields()],
            'site_config' => $this->site_config
        ]);
    }

    public function glossary(){
        $types = Type::with('values')->get();
        return view('pages.glossary',[
            'title'=>'Glossary',
            'data'=>[
                'types' => $types
            ],
            'site_config' => $this->site_config
        ]);
    }

    public function activity(Request $request, Activity $activity){
        $files = File::where('activity_id',$activity->id)->get();
        if (!is_null($activity->video_url)) {
            $video_embed = OEmbed::get($activity->video_url);
            $video_html = $video_embed->html(['width' => 400]);
        } else {
            $video_html = null;
        }
        return view('pages.activity',[
            'activity'=>$activity->withPlainTextValues(),
            'files'=>$files,
            'video_html'=>$video_html,
            'site_config' => $this->site_config
        ]);
    }

    public function manage(Request $request){
        if (Auth::check()) {
            return view('pages.manage',[
                'activities_form_fields'=>Activity::get_form_fields(),
                'site_config' => $this->site_config
            ]);
        } else {
            return redirect(url('/manage/login'));
        }
    }

}
