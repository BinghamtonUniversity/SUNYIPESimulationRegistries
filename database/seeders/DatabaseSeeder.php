<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\IPE;
use App\Models\Permission;
use App\Models\Simulation;
use App\Models\SiteConfiguration;
use App\Models\SUNYCampus;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        SUNYCampus::create([
            "name" => "Binghamton University"
        ]);

        User::create([
            'first_name' => 'Ali Kemal',
            'last_name' => 'Tanriverdi',
            'unique_id' => 'atanrive@binghamton.edu',
            'email' => 'atanrive@binghamton.edu',
            "suny_campus_id"=>1,
        ]);
        User::create([
            'first_name' => 'Timothy',
            'last_name' => 'Cortesi',
            'unique_id' => 'tcortesi@binghamton.edu',
            'email' => 'tcortesi@binghamton.edu',
            "suny_campus_id"=>1,
        ]);

        Permission::create([
           'user_id' => 1,
           'permission'=>'manage_permissions'
        ]);
        Permission::create([
            'user_id' => 2,
            'permission'=>'manage_permissions'
        ]);

        Activity::create([
            "title"=>"Test Activity",
            "submitter_id"=>1,
            "description"=>"A very nice first IPE Activity",
            "type"=>"ipe",
            "status"=>"approved",
            "approved_by"=>1,
            'approved_at'=>now()
        ]);
        Activity::create([
            "title"=>"Test Simulation",
            "submitter_id"=>1,
            "description"=>"A very nice second Simulation Activity",
            "type"=>"simulation",
            "status"=>"approved",
            "approved_by"=>1,
            'approved_at'=>now()
        ]);
        Activity::create([
            "title"=>"Test IPE/Simulation",
            "submitter_id"=>1,
            "description"=>"A very nice second IPE/Simulation Activity",
            "type"=>"ipe_simulation",
            "status"=>"approved",
            "approved_by"=>1,
            'approved_at'=>now()
        ]);

        SiteConfiguration::create([
            "key"=>"page.home.body",
            "value"=>"<div class='alert alert-info'>Welcome to the jungle!</div>"
        ]);
        SiteConfiguration::create([
            "key"=>"footer",
            "value"=>"
                <span>SUNY IPE/Simulation Registry <br> &copy; 2024 Binghamton University
                | <a href='https://www.binghamton.edu' target='_blank' style='color:white;'>Binghamton University</a></span>"
        ]);

    }
}
