<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'slug', 'about','profile_id'
    ];


    public function owner(){
        return $this->hasMany(Profile::class);
    }

    public function members(){
        return $this->belongsToMany(Profile::class,'team_members')->withPivot('type','id')->withTimestamps();
    }


}
