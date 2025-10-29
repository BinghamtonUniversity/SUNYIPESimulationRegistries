<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\IPE;
use App\Models\Permission;
use App\Models\Simulation;
use App\Models\SiteConfiguration;
use App\Models\Campus;
use App\Models\User;
use App\Models\Type;
use App\Models\Value;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Campus::create([
            "name" => "Binghamton University"
        ]);

        User::create([
            'first_name' => 'Ali Kemal',
            'last_name' => 'Tanriverdi',
            'unique_id' => 'atanrive@binghamton.edu',
            'email' => 'atanrive@binghamton.edu',
            "campus_id"=>1,
        ]);
        User::create([
            'first_name' => 'Timothy',
            'last_name' => 'Cortesi',
            'unique_id' => 'tcortesi@binghamton.edu',
            'email' => 'tcortesi@binghamton.edu',
            "campus_id"=>1,
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
            "is_ipe"=>true,
            "status"=>"approved",
            "approved_by"=>1,
            'approved_at'=>now()
        ]);
        Activity::create([
            "title"=>"Test Simulation",
            "submitter_id"=>1,
            "description"=>"A very nice second Simulation Activity",
            "is_simulation"=>true,
            "status"=>"approved",
            "approved_by"=>1,
            'approved_at'=>now()
        ]);
        Activity::create([
            "title"=>"Test IPE/Simulation",
            "submitter_id"=>1,
            "description"=>"A very nice second IPE/Simulation Activity",
            "is_simulation"=>true,
            "is_ipe"=>true,
            "status"=>"approved",
            "approved_by"=>1,
            'approved_at'=>now()
        ]);

        SiteConfiguration::create([
            "key"=>"page.home.body",
            "value"=>"<h1 class='alert alert-info'>Welcome to the SUNY Share!</div>"
        ]);
        SiteConfiguration::create([
            "key"=>"footer",
            "value"=>"
                <span>IPE/Simulation Registry <br> &copy; 2024 Binghamton University
                | <a href='https://www.binghamton.edu' target='_blank' style='color:white;'>Binghamton University</a></span>"
        ]);
        SiteConfiguration::create([
            "key"=>"pages.browse_activities.help_text",
            "value"=>"<p>Activities are submitted under the CC BY-NC license. This license enables users to adapt and build upon the activities for noncommercial purposes. We encourage you to modify an activity to fit your needs. The user may also distribute the activity. When using or distributing the activity, credit for authorship must be given. Activities are vetted by simulation and/or IPE content experts for essential activity components prior to approval for inclusion.</p>"
        ]);
        SiteConfiguration::create([
            "key"=>"email.activity.admin.review.subject",
            "value"=>"<p>Activity submitted for review: {{activity.id}}</p>"
        ]);
        SiteConfiguration::create([
            "key"=>"email.activity.admin.review.content",
            "value"=>"<p>An activity is waiting for your review: {{activity.title}}</p>"
        ]);

        $type_values = collect([
            [
                'name' => 'System',
                'ipe' => true, 'simulation' => true,
                'values' => collect([
                    'Neuro',
                    'HEENT',
                    'Cardiac',
                    'Respiratory',
                    'Gi',
                    'GU',
                    'Skin',
                    'Musculoskeletal',
                    'Other',
                ]),
            ],[
                'name' => 'Population',
                'ipe' => true, 'simulation' => true,
                'values' => collect([
                    'Maternal/Newborn',
                    'Adult',
                    'Geriatric',
                    'Newborn (0-3 month)',
                    'Infant (3 - 18 month)',
                    'Toddler (18 month - 3 yr)',
                    'Preschool (3 - 5 yr)',
                    'School Age (5 - 12 yr)',
                    'Adolescent (12 - 18 yr)',
                    'Other'
                ]),
            ],[
                'name' => 'Program',
                'ipe' => true, 'simulation' => true,
                'values' => collect([
                    'Behavioral Health',
                    'Dentistry',
                    'Education',
                    'Medical',
                    'Nursing, Advanced Practice',
                    'Nursing, Prelicensure',
                    'Occupational Therapy',
                    'Pharmacy',
                    'Physical Therapy',
                    'Public Health',
                    'Respiratory Therapy',
                    'Social Work',
                    'Speech and Language Pathology',
                    'Other'
                ]),
            ],[
                'name' => 'Scenario Setting',
                'ipe' => true, 'simulation' => true,
                'values' => collect([
                    'Community',
                    'Early Intervention',
                    'Home Care',
                    'Hospital',
                    'Long Term Care',
                    'Outpatient Office',
                    'Provider Office',
                    'Rehab Center',
                    'School-Based',
                    'Other'
                ]),
            ],[
                'name' => 'Experience',
                'ipe' => true, 'simulation' => true,
                'values' => collect([
                    'Hybrid',
                    'In Person',
                    'Online',
                    'Virtual Reality',
                    'Other',
                    'Experiential',
                    'Summative',
                    'High-Stakes',
                    'OSCE',
                    'Activity within a course',
                    'Full course',
                    'Co/Extra Curricular',
                    'One time experience'
                ]),
            ],[
                'name' => 'Patient Type',
                'ipe' => true, 'simulation' => true,
                'values' => collect([
                    'Standardized Patient',
                    'Role Play',
                    'Manikin',
                    'Task Trainer',
                    'Paper'
                ]),
            ],[
                'name' => 'Time to Complete',
                'ipe' => false, 'simulation' => true,
                'values' => collect([
                    'Less than 15 minutes',
                    'Less than 30 minutes',
                    'Less than 60 minutes',
                    'More than 60 minutes'
                ])
            ]
        ]);

        $type_values->each(function($elem) {
            $type = Type::create([
                'type' => $elem['name'],
                'is_ipe' => $elem['ipe'], 'is_simulation' => $elem['simulation'],
            ]);
            $elem['values']->each(function($elem2) use ($type)  {
                $value = Value::create([
                    'type_id' => $type->id,
                    'value' => $elem2,
                    'is_ipe' => true, 'is_simulation' => true,
                ]);
            });
        });
    }
}
