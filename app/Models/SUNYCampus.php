<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SUNYCampus extends Model
{
    use HasFactory;
    protected $table = 'suny_campuses';
    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
