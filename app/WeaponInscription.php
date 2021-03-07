<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeaponInscription extends Model
{
    protected $table = 'weapon_inscription';

    protected $fillable = ['inscription_id', 'weapon_id', 'note', 'fps'];



    public function inscription()
    {
        return $this->belongsTo(ProfileEvent::class);
    }

    public function weapon(){
        return $this->belongsTo(Weapon::class);
    }
}
