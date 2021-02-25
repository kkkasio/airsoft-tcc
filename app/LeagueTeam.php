<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueTeam extends Model
{
    protected $fillable = [
        'league_id', 'team_id'
    ];

    protected $table = 'league_team';


    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function league(){
        return $this->belongsTo(League::class);
    }

    public function organizer(){
        return  $this->hasMany(Event::class,'team_id','team_id');
    }


}
