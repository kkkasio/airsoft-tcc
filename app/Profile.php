<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    protected $fillable = [
        'slug', 'name', 'birthday', 'user_id', 'nickname', 'gender', 'state_id', 'city_id'
    ];


    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function team()
    {
        return $this->hasOne(ProfileTeam::class);
    }

    public function league()
    {
        return $this->hasOne(ProfileLeague::class);
    }

    public function getInitialsAttribute()
    {
        $name = explode(' ', $this->name);

        if (isset($name[1])) {

            return substr($name[0], 0, 1) . substr($name[1], 0, 1);
        }
        return substr($name[0], 0, 1);
    }
}
