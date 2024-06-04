<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSUNYCampusRequest;
use App\Http\Requests\UpdateSUNYCampusRequest;
use App\Models\SUNYCampus;
use Illuminate\Http\Request;

class SUNYCampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return SUNYCampus::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $suny_campus = new SUNYCampus($request->all());
        $suny_campus->save();

        return $suny_campus;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSUNYCampusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SUNYCampus $suny_campus)
    {
        return $suny_campus;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SUNYCampus $suny_campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SUNYCampus $suny_campus)
    {
        $suny_campus->update($request->all());

        return $suny_campus;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SUNYCampus $suny_campus)
    {
        $suny_campus->delete();

        return 1;
    }
}
