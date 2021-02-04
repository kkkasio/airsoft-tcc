<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileLeague extends Model
{
    protected $table = 'league_profile';


    protected $fillable = ['profile_id','league_id','type'];



    public function profile(){
        return $this->belongsTo(Profile::class);
    }


    public function league(){
        return $this->belongsTo(League::class);
    }


}
