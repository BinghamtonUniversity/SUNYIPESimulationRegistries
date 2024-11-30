<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDownloadLog extends Model
{
    use HasFactory;
    protected $fillable = ['activity_id','file_id','name','organization','email'];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
    public function file() {
        return $this->belongsTo(File::class);
    }
}
