<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'players', 'about', 'type', 'status', 'location', 'league_id', 'team_id', 'file', 'startdate', 'enddate', 'eventdate'
    ];

    protected $casts = [
        'startdate' => 'datetime:Y-m-d H:i',
        'enddate' => 'datetime:Y-m-d H:i',
    ];


    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function subscribers()
    {
        return $this->hasMany(ProfileEvent::class);
    }

    public function ratings()
    {
        return $this->hasMany(EventEvaluate::class);
    }

    public function squads()
    {
        return $this->hasMany(EventSquad::class);
    }
}
