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

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function hasTeam(){
        if($this->hasOne(Team::class)){
            return $this->hasOne(Team::class);
        }else {
            echo 'falhou';
        }
    }

    public function teamMember(){
        return $this->belongsToMany(Team::class,'team_members')->withTimestamps();
    }

    public function myTeam(){
        return $this->belongsToMany(Team::class,'team_members')->withPivot('type')->withTimestamps();
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

    public function getInitialsAttribute()
    {
        $name = explode(' ', $this->name);

        if (isset($name[1])) {

            return substr($name[0], 0, 1) . substr($name[1], 0, 1);
        }
        return substr($name[0], 0, 1);
    }
}
