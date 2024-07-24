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
                "name" => "is_ipe",
                "type" => "switch",
                "label" => "IPE Related",
                "options" => [
                    [
                        "label" => "No",
                        "value" => false
                    ],
                    [
                        "label" => "Yes",
                        "value" => true
                    ]
                ]
            ],
            [
                "name" => "is_simulation",
                "type" => "switch",
                "label" => "Simulation",
                "options" => [
                    [
                        "label" => "No",
                        "value" => false
                    ],
                    [
                        "label" => "Yes",
                        "value" => true
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
                "name" => "ksa_requirement",
                "type" => "text",
                "label" => "KSA Requirements"
            ],
            [
                "name" => "learning_objectives",
                "type" => "text",
                "label" => "Learning Objectives"
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
