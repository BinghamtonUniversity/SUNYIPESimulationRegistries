<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;
use App\Models\ActivityDownloadLog;
use App\Models\ActivityValue;
use App\Models\File;

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
            if(str_starts_with($type, "type_") && !is_null($value)) {
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

    public function index_files(Request $request, Activity $activity) {
        return File::where('activity_id',$activity->id)->get();
    }

    public function upload_file(Request $request, Activity $activity) {
        $file = $request->file('filepond');    
        $uploaded_file = new File([
            'activity_id' => $activity->id,
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'ext' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getClientMimeType(),
        ]);
        $uploaded_file->user_id_created = Auth::user()->id;
        $uploaded_file->save();

        $path = 'activities/'.$activity->id;
        if (!Storage::disk('local')->exists($path)) {
            Storage::disk('local')->makeDirectory($path);
        }    

        $new_file_name = $uploaded_file->id.'.'.$uploaded_file->ext;
        $filePath = Storage::disk('local')->putFileAs($path, $file, $new_file_name);

        return response()->json(['filePath' => $filePath]);
    }

    public function download_file(Request $request, Activity $activity, File $file) {
        if (!($request->has('name') && $request->has('organization') && $request->has('email'))) {
            return response()->json(['message' => 'Required name, organization, and email not provided'], 403);
        }
        $log = new ActivityDownloadLog([
            'activity_id' => $activity->id,
            'file_id' => $file->id,
            'name' => $request->name,
            'organization' => $request->organization,
            'email' => $request->email,
        ]);
        $log->save();
        $file_path = 'activities/'.$activity->id.'/'.$file->id.'.'.$file->ext;
        if (Storage::disk('local')->exists($file_path)) {
            return Storage::disk('local')->download($file_path, $file->name.'.'.$file->ext);
        } else {
            return response()->json(['message' => 'File does not exist'], 404);
        }
    }

    public function rename_file(Request $request, Activity $activity, File $file) {
        $file->name = $request->name;
        $file->save();
        return $file;
    }

    public function delete_file(Request $request, Activity $activity, File $file) {
        $file->user_id_deleted = Auth::user()->id;
        $file->save();
        $file->delete();
        $file_path = 'activities/'.$activity->id.'/'.$file->id.'.'.$file->ext;
        if (Storage::disk('local')->exists($file_path)) {
            Storage::disk('local')->delete($file_path);
        } 
        return 1;
    }

    public function activity_logs(Request $request, Activity $activity) {
        return ActivityDownloadLog::where('activity_id',$activity->id)
            ->with('file')
            ->orderBy('created_at')->get();
    }

    public function get_form_fields(Request $request) {
        return Activity::get_form_fields();
    }

    public function get_search_form_fields(Request $request) {
        return Activity::get_search_form_fields();
    }
}
