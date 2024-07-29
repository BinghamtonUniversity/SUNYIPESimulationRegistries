<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Activity::all();
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
        return $activity;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Activity $activity)
    {
        return $activity;
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
        $activity->update($request->all());

        return $activity;
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
}
