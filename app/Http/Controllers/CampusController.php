<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampusRequest;
use App\Http\Requests\UpdateCampusRequest;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Campus::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampusRequest $request)
    {
        $campus = new Campus($request->all());
        $campus->save();

        return $campus;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campus $campus)
    {
        return $campus;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampusRequest $request, Campus $campus)
    {
        $campus->update($request->all());

        return $campus;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campus $campus)
    {
        $campus->delete();

        return 1;
    }
}
