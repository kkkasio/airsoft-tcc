<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSquad extends Model
{
    protected $table = 'event_squad';

    protected $fillable = ['event_id','squad'];



    public function squadMembers(){
        return $this->hasMany(ProfileEvent::class,'squad_id','id');
    }
}
