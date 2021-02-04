<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileTeam extends Model
{
    protected $table = 'team_members';
    protected $fillable = ['type', 'team_id', 'profile_id'];



    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
