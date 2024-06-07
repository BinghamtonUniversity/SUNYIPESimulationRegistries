<?php

namespace Database\Seeders;

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
            'email' => 'atanrive@binghamton.edu',
            "suny_campus_id"=>1,
            'password' => Hash::make('password'),
        ]);
        User::create([
            'first_name' => 'Timothy',
            'last_name' => 'Cortesi',
            'email' => 'tcortesi@binghamton.edu',
            "suny_campus_id"=>1,
            'password' => Hash::make('password'),
        ]);

        Permission::create([
           'user_id' => 1,
           'permission'=>'manage_permissions'
        ]);
        Permission::create([
            'user_id' => 2,
            'permission'=>'manage_permissions'
        ]);

        IPE::create([
            "name"=>"Test IPE",
            "user_id"=>1,
            "description"=>"A very nice first IPE"
        ]);
        IPE::create([
            "name"=>"Test IPE 2",
            "user_id"=>1,
            "description"=>"A very nice second IPE"
        ]);

        Simulation::create([
            "name"=>"Test Simulation",
            "user_id"=>1,
            "description"=>"A very nice first Simulation"
        ]);
        Simulation::create([
            "name"=>"Test Simulation 2",
            "user_id"=>1,
            "description"=>"A very nice second Simulation"
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
