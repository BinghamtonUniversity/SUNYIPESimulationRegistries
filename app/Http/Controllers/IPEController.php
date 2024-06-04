<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIPERequest;
use App\Http\Requests\UpdateIPEsRequest;
use App\Models\IPE;
use Illuminate\Http\Request;

class IPEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return IPE::get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, IPE $ipe)
    {
        $ipe = new IPE($request->all());
        $ipe->save();

        return $ipe;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIPERequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, IPE $ipe)
    {
        return $ipe;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, IPE $ipe)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IPE $ipe)
    {
        $ipe->update($request->all());

        return $ipe;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, IPE $ipe)
    {
        $ipe->delete();
        return 1;
    }
}
