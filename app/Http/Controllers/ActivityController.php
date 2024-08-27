<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\ActivityValue;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::get();
        foreach ($activities as $activity) {
            $activity->withValuesModified();
        }

        return $activities;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreActivityRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        $activity = new Activity($request->all());

        $activity->save();

        foreach($request->all() as $type => $value) {
            if(str_contains( $value, "value_")){
                $value = explode("value_", $value)[1];
                ActivityValue::updateOrCreate([
                    'activity_id'=>$activity->id, 'value_id'=>$value
                ]);
            }
        }

        return $activity->withValuesModified();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Activity $activity)
    {
        return $activity->withValuesModified();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {

        $request = $request->all();
        foreach($request as $type => $value) {
            if(str_contains( $value, "value_")){
                $value = explode("value_", $value)[1];
                ActivityValue::updateOrCreate([
                    'activity_id'=>$activity->id, 'value_id'=>$value
                ]);
            }
        }

        $activity->update($request);
        return $activity->withValuesModified();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Activity $activity)
    {
        $activity->delete();

        return 1;
    }

    public function index_logs(Request $request, Activity $activity){
        return ActivityLog::where('activity_id',$activity->id)->get();
    }

    public function get_form_fields(Request $request) {
        return Activity::get_form_fields();
    }

    public function get_search_form_fields(Request $request) {
        return Activity::get_search_form_fields();
    }
}
