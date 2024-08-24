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

}
