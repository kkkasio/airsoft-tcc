<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamInvite extends Model
{
    protected $database = 'team_invites';

    protected $fillable = ['code','used','profile_id','team_id'];


    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function members(){
        return $this->belongsTo(Profile::class);
    }

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
