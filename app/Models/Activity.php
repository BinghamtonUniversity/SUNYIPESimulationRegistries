<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ["is_ipe","is_simulation","title","submitter_id","description", "contact_name", "contact_email", "contact_phone",
        "ksa_requirement","number_of_learners","status",'learning_objectives'];

    protected $casts = [
        'is_simulation' => 'boolean','is_ipe' => 'boolean'
    ];

    public function user(){
        return $this->belongsTo(User::class,'submitter_id');
    }

    static public function get_fields(){
        return config('form_fields.activities');
    }

    public function values() {
        return $this->belongsToMany(Value::class,'activity_values','activity_id','value_id');
    }

    public function activity_values(){
        return $this->hasMany(ActivityValue::class, 'activity_id');
    }

    public function campus() {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function files(){
        return $this->hasMany(File::class, 'activity_id');
    }

    public function withValuesModified(){
        $types = Type::select('id','multi_select')->get();
        $temp = (Object)[];
        foreach ($this->values as $value) {
            $current_type = $types->firstWhere('id',$value->type_id);
            if ($current_type->multi_select === true) {
                if (!isset($temp->{'type_'.$value->type_id})) {
                    $temp->{'type_'.$value->type_id} = [];
                }
                $temp->{'type_'.$value->type_id}[] = "value_".$value->id;
            } else {
                $temp->{'type_'.$value->type_id} = "value_".$value->id;
            }
        }
        foreach($temp as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    public function withPlainTextValues() {
        $type_ids = $this->values->pluck('type_id')->unique();
        $value_ids = $this->values->pluck('id')->unique();
        $types = Type::select('id','type','multi_select')->whereIn('id',$type_ids)->get();
        $values = Value::select('id','type_id','value')->whereIn('id',$value_ids)->get();
        $my_types = [];
        foreach($types as $type) {
            $my_values = $values->where('type_id',$type->id)->pluck('value')->toArray();
            if (count($my_values) === 1) {
                $my_values = $my_values[0];
            }
            $my_types[] = [
                'type' => $type->type, 'value' => $my_values,
            ];
        }
        $this->plain_text_values = $my_types;
        return $this;
    }

    static public function get_form_fields() {
        $form_fields = [
            [
                "name" => "id",
                "type" => "hidden"
            ],
            [
                "name" => "title",
                "type" => "text",
                "label" => "Title",
                "required" => true,
                "limit" => 255,
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
                "name" => "description",
                "type" => "textarea",
                "label" => "Description",
                "required" => true,
                "limit" => 65535,
                "showColumn"=>false,
            ],
            [
                "name" => "contact_name",
                "type" => "text",
                "label" => "Contact Name",
                "required" => true,
                "limit" => 255,
            ],
            [
                "name" => "contact_email",
                "type" => "email",
                "label" => "Contact Email",
                "required" => true,
                "limit" => 255,
            ],
            [
                "name" => "ksa_requirement",
                "type" => "textarea",
                "label" => "KSA Requirements",
                "required" => true,
                "limit" => 65535,
                "showColumn"=>false,
            ],
            [
                "name" => "learning_objectives",
                "type" => "textarea",
                "label" => "Learning Objectives",
                "required" => true,
                "limit" => 65535,
                "showColumn"=>false,
            ],
            [
                "name" => "number_of_learners",
                "type" => "number",
                "label" => "Number of Learners",
                "required" => true,
                "showColumn"=>false,
            ]
        ];

        $all_types = Type::with('values')->get();
        $all_types->each(function($type,$type_index) use (&$form_fields) {
            $field = [
                "showColumn"=>false,
                'label' => $type->type,
                'name' => 'type_'.$type->id,
            ];
            if ($type->multi_select === true) {
                $field['type'] = 'radio';
                $field['multiple'] = true;
            } else {
                $field['type'] = 'select';
            }
            $field['show'] = [['op' => 'or','conditions'=> []]];
            if ($type->is_ipe === true) {
                $field['show'][0]['conditions'][] = [
                    'type'=> 'matches',
                    'name'=> 'is_ipe',
                    'value'=> [true]
                ];
            }
            if ($type->is_simulation === true) {
                $field['show'][0]['conditions'][] = [
                    'type'=> 'matches',
                    'name'=> 'is_simulation',
                    'value'=> [true]
                ];
            }
            $ipe_only_options = [
                'label' => '', // IPE Only
                'type' => 'optgroup',
                'show' => [['op' => 'or',
					'conditions'=> [[
                        'type'=> 'matches',
                        'name'=> 'is_ipe',
                        'value'=> [true]
                    ]]
                ]],
                'options' => $type->values
                    ->where('is_ipe',true)->where('is_simulation',false)
                    ->map(function($value) {
                        return ['label' => $value->value,'value' => 'value_'.$value->id];
                    })->values()->toArray(),
            ];
            $simulation_only_options = [
                'label' => '', // Simulation Only
                'type' => 'optgroup',

                'show' => [['op' => 'or',
					'conditions'=> [[
                        'type'=> 'matches',
                        'name'=> 'is_simulation',
                        'value'=> [true]
                    ]]
                ]],
                'options' => $type->values
                    ->where('is_ipe',false)->where('is_simulation',true)
                    ->map(function($value) {
                        return ['label' => $value->value,'value' => 'value_'.$value->id];
                    })->values()->toArray(),
            ];
            $all_options = [
                'label' => '', // Both IPE AND Simulation
                'type' => 'optgroup',
                'show' => [['op' => 'or',
                    'conditions'=> [[
                        'type'=> 'matches',
                        'name'=> 'is_ipe',
                        'value'=> [true]
                    ],[
                        'type'=> 'matches',
                        'name'=> 'is_simulation',
                        'value'=> [true]
                    ]]
                ]],
                'options' => $type->values
                    ->where('is_ipe',true)->where('is_simulation',true)
                    ->map(function($value) {
                        return ['label' => $value->value,'value' => 'value_'.$value->id];
                    })->values()->toArray(),
            ];
            $field['options'] = [$all_options,$ipe_only_options,$simulation_only_options];
            $form_fields[] = $field;
        });
        return $form_fields;
    }

    static public function get_search_form_fields() {
        $form_fields = [
            [
                "name" => "is_ipe",
                "type" => "switch",
                "label" => "IPE Related",
                'columns' => 6,
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
                'columns' => 6,
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
            ]
        ];
        
        $type_fields = [];
        $all_types = Type::with('values')->get();
        $all_types
            ->where('searchable',true)
            ->each(function($type,$type_index) use (&$type_fields) {
            $field = [
                'label' => $type->type,
                'name' => 'type_'.$type->id,
                'type' => 'radio',
                'columns' => 2,
                'multiple' => true
            ];
            $field['show'] = [['op' => 'or','conditions'=> []]];
            if ($type->is_ipe === true) {
                $field['show'][0]['conditions'][] = [
                    'type'=> 'matches',
                    'name'=> 'is_ipe',
                    'value'=> [true]
                ];
            }
            if ($type->is_simulation === true) {
                $field['show'][0]['conditions'][] = [
                    'type'=> 'matches',
                    'name'=> 'is_simulation',
                    'value'=> [true]
                ];
            }
            $field['options'] = $type->values->map(function($value) {
                return ['label' => $value->value,'value' => 'value_'.$value->id];
            })->values()->toArray();
            $type_fields[] = $field;
        });
        $form_fields[] = [
            "type" => "fieldset",
            "label" => "",
            "name" => "types",
            "fields" => $type_fields
        ];
        return $form_fields;
    }

}
