<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSquad extends Model
{
    protected $table = 'event_squad';

    protected $fillable = ['event_id','name'];


    public function squadMembers(){
        return $this->hasMany(ProfileEvent::class,'squad_id','id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id','id');

    }
}
