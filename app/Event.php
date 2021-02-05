<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
     protected $fillable = [
        'name', 'players','about','type','status','league_id','team_id','file','startdate','enddate'
    ];

    protected $casts = [
        'startdate' => 'datetime:Y-m-d H:i',
        'enddate' => 'datetime:Y-m-d H:i',
    ];


    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function league(){
        return $this->belongsTo(League::class);
    }

    public function comments(){
        return $this->hasMany(Event::class);
    }

    public function subscribers(){
        return 'aqui vem os inscritos';
    }
}
