<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ["type","title","submitter_id","description", "contact_name", "contact_email", "contact_phone",
        "participating_programs","ksa_requirement","focus_areas",
        "learning_objectives","is_new","number_of_learners","status"];
    public function user(){
        return $this->belongsTo(User::class);
    }
    static public function get_fields(){
        return config('form_fields.activities');
    }
    public function values() {
        return $this->belongsToMany(Value::class,'activity_values','activity_id','value_id');
    }

    public function activity_values(){
        return $this->hasMany(ActivityValue::class);
    }

    public function campus() {
        return $this->belongsTo(Campus::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }

}
