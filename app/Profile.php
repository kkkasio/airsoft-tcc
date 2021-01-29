<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'slug', 'name', 'birthday','user_id'
    ];


    public function weapon(){
        return $this->hasMany(Weapon::class);
    }

    public function team(){
        return $this->hasOne(Team::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
