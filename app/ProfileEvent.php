<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileEvent extends Model
{
    protected $table = 'profile_event';

    protected $fillable = ['event_id','profile_id','squad_id'];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function squad(){
        return $this->belongsTo(EventSquad::class);
    }
}
