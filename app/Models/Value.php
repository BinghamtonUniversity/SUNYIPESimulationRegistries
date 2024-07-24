<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;
    protected $table = 'values';
    protected $fillable = [
        'value','is_ipe','is_simulation'
    ];
    protected $casts = [
        'is_simulation' => 'boolean','is_ipe' => 'boolean'
    ];

    public function activities() {
        return $this->belongsToMany(Activity::class,'activity_values','value_id','activity_id');
    }

    public function activity_values(){
        return $this->hasMany(ActivityValue::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

}