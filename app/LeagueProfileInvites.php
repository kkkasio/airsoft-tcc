<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueProfileInvites extends Model
{
    protected $table = 'league_profile_invite';

    protected $fillable = ['code','used','league_id','profile_id'];


    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function league(){
        return $this->belongsTo(League::class);
    }
}
