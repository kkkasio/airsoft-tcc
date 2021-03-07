<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileEvent extends Model
{
    protected $table = 'profile_event';

    protected $fillable = ['event_id', 'profile_id', 'squad_id'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public   function event()
    {
        return  $this->belongsTo(Event::class);
    }

    public function squad()
    {
        return $this->belongsTo(EventSquad::class);
    }

    public function weapons()
    {
        return $this->hasMany(WeaponInscription::class, 'inscription_id','id');
    }
}
