<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSimulationRequest;
use App\Http\Requests\UpdateSimulationRequest;
use App\Models\Simulation;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Simulation::get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $simulation = new Simulation($request->all());
        $simulation->save();

        return $simulation;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSimulationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Simulation $simulation)
    {
        return $simulation;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Simulation $simulation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Simulation $simulation)
    {
        $simulation->update($request->all());

        return $simulation;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Simulation $simulation)
    {
        $simulation->delete();

        return 1;
    }
}
