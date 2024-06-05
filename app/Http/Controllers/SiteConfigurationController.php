<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteConfigurationRequest;
use App\Http\Requests\UpdateSiteConfigurationRequest;
use App\Models\SiteConfiguration;
use Illuminate\Http\Request;

class SiteConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SiteConfiguration::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $site_configuration = new SiteConfiguration($request->all());
        $site_configuration->save();

        return $site_configuration;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteConfigurationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SiteConfiguration $siteConfiguration)
    {
        return $siteConfiguration;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteConfiguration $siteConfiguration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiteConfiguration $siteConfiguration)
    {
        $siteConfiguration->update($request->all());

        return $siteConfiguration;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteConfiguration $siteConfiguration)
    {
        //
    }
}
