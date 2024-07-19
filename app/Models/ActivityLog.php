<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $fillable = ['activity_id','user_id_created','user_id_deleted','data','user_id_created','user_id_deleted'];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}
