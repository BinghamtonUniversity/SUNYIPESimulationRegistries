<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityValue extends Model
{
    use HasFactory;

    protected $table = 'activity_values';
    protected $fillable = ['activity_id','value_id'];
    protected $casts = [];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function value() {
        return $this->belongsTo(Value::class);
    }
}
