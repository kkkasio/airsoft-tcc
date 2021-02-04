<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'slug', 'about', 'profile_id'
    ];


    public function owner()
    {
        return $this->hasOne(Profile::class, 'id', 'profile_id');
    }

    public function members()
    {
        return $this->hasMany(ProfileTeam::class);
    }

    public function league()
    {
        return $this->hasOne(LeagueTeam::class);
    }

    public function getInitialsAttribute()
    {
        $name = explode(' ', $this->name);

        if (isset($name[1])) {

            return substr($name[0], 0, 1) . substr($name[1], 0, 1);
        }
        return substr($name[0], 0, 1);
    }
}
