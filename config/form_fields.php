<?php

return [
    // Listing
    'activities' =>
        [
            [
                "name" => "id",
                "type" => "hidden"
            ],
            [
                "name" => "type",
                "type" => "select",
                "label" => "type",
                "options" => [
                    [
                        "label" => "IPE",
                        "value" => "ipe"
                    ],
                    [
                        "label" => "Simulation",
                        "value" => "simulation"
                    ],
                    [
                        "label" => "IPE/Simulation",
                        "value" => "ipe_simulation"
                    ]
                ]
            ],
            [
                "name" => "title",
                "type" => "text",
                "label" => "Title"
            ],
            [
                "name" => "description",
                "type" => "textarea",
                "label" => "Description"
            ],
            [
                "name" => "contact_name",
                "type" => "text",
                "label" => "Contact Name"
            ],
            [
                "name" => "contact_email",
                "type" => "email",
                "label" => "Contact Email"
            ],
            [
                "name" => "participating_programs",
                "type" => "select",
                "label" => "Participating Programs",
                "options" => [
                    "Advanced Practice Nursing",
                    "Education",
                    "Occupational Therapy",
                    "Pharmacy",
                    "Physical Therapy",
                    "Prelicensure Nursing",
                    "Public Health",
                    "Social Work",
                    "Speech and Language Pathology"
                ]
            ],
            [
                "name" => "ksa_requirement",
                "type" => "text",
                "label" => "KSA Requirements"
            ],
            [
                "name" => "focus_areas",
                "type" => "text",
                "label" => "Focus Areas"
            ],
            [
                "name" => "learning_objectives",
                "type" => "text",
                "label" => "Learning Objectives"
            ],
            [
                "name" => "is_new",
                "type" => "switch",
                "label" => "Is New?",
                "options" => [
                    [
                        "label" => "False",
                        "value" => 0
                    ],
                    [
                        "label" => "True",
                        "value" => 1
                    ]
                ]
            ],
            [
                "name" => "number_of_learners",
                "type" => "text",
                "label" => "Number of Learners"
            ],
            [
                "name" => "status",
                "type" => "select",
                "label" => "Status",
                "show"=>false,
                "options" => [
                    [
                        "label" => "Submitted",
                        "value" => "submitted"
                    ],
                    [
                        "label" => "Under Review",
                        "value" => "reviewss"
                    ],
                    [
                        "label" => "Approved",
                        "value" => "approved"
                    ]
                ]
            ],
//            [
//                "name" => "approved_by",
//                "type" => "user",
//                "label" => "Approved By",
//                "show" => false,
//                "template" => "{{user.first_name}}"
//            ]
        ]
];
