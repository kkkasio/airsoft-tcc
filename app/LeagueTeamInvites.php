<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueTeamInvites extends Model
{
    protected $table = 'league_team_invite';
    protected $fillable = ['code','league_id','used'];


    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function league(){
        return $this->belongsTo(League::class);
    }
}
