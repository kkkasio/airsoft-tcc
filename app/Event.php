<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
     protected $fillable = [
        'name', 'date', 'players','about','type','status','league_id','team_id'
    ];


    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function  league(){
        return $this->belongsTo(League::class);
    }

    public function comments(){
        return $this->hasMany(Event::class);
    }
}
