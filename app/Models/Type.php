<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';
    protected $fillable = [
        'type','is_ipe','is_simulation','searchable','multi_select','in_glossary','order','help_text',
    ];
    protected $casts = [
        'searchable' => 'boolean','multi_select' => 'boolean','is_simulation' => 'boolean','is_ipe' => 'boolean', 'in_glossary' => 'boolean'
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

    public function values(){
        return $this->hasMany(Value::class);
    }

}