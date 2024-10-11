<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Value extends Model
{
    use HasFactory;
    protected $table = 'values';
    protected $fillable = [
        'value','is_ipe','is_simulation','order','help_text',
    ];
    protected $casts = [
        'is_simulation' => 'boolean','is_ipe' => 'boolean'
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

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