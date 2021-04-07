<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = [
        'name', 'slug', 'avatar', 'about', 'state_id', 'city_id', 'user_id'
    ];

    protected $dates = ['foundation'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function teams()
    {
        return $this->hasMany(LeagueTeam::class);
    }

    public function teamInvite()
    {
        return $this->hasMany(LeagueTeamInvites::class, 'team_id', 'league_id');
    }

    public function members()
    {
        return $this->hasMany(ProfileLeague::class);
    }
}
