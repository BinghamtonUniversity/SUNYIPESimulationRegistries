<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\ActivityValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $activity->submitter_id = Auth::user()->id;
        $activity->save();
        foreach($request->all() as $type => $value) {
            if(str_starts_with( $type, "type_")) {
                // Handle Multi-Select Types
                if (is_array($value)) {
                    foreach($value as $value_item) {
                        $value_item = explode("value_", $value_item)[1];
                        ActivityValue::updateOrCreate([
                            'activity_id'=>$activity->id, 'value_id'=>$value_item
                        ]);        
                    }
                } else {
                    $value = explode("value_", $value)[1];
                    ActivityValue::updateOrCreate([
                        'activity_id'=>$activity->id, 'value_id'=>$value
                    ]);
                }
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
    public function update(UpdateActivityRequest $request, Activity $activity) {
        $activity->update($request->all());
        $updated_value_ids = collect();
        foreach($request->all() as $type => $value) {
            if(str_starts_with( $type, "type_")) {
                // Handle Multi-Select Types
                if (is_array($value)) {
                    foreach($value as $value_item) {
                        $value_item = explode("value_", $value_item)[1];
                        ActivityValue::updateOrCreate([
                            'activity_id'=>$activity->id, 'value_id'=>$value_item
                        ]);   
                        $updated_value_ids[] = $value_item;     
                    }
                } else {
                    $value = explode("value_", $value)[1];
                    ActivityValue::updateOrCreate([
                        'activity_id'=>$activity->id, 'value_id'=>$value
                    ]);
                    $updated_value_ids[] = $value;
                }
            }
        }
        // Delete Any Removed Values
        $current_value_ids = ActivityValue::where('activity_id',$activity->id)->get()->pluck('value_id');
        $delete_value_ids = $current_value_ids->diff($updated_value_ids);
        ActivityValue::where('activity_id',$activity->id)->whereIn('value_id',$delete_value_ids)->delete();

        return $activity->withValuesModified();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Activity $activity)
    {
        ActivityValue::where('activity_id',$activity->id)->delete();
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
