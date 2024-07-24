<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';
    protected $fillable = [
        'type','is_ipe','is_simulation','searchable'
    ];
    protected $casts = [
        'searchable' => 'boolean','is_simulation' => 'boolean','is_ipe' => 'boolean'
    ];

    public function values(){
        return $this->hasMany(Value::class);
    }

}