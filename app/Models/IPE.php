<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPE extends Model
{
    use HasFactory;
    protected $table = 'ipes';
    protected $fillable = ["name","user_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}