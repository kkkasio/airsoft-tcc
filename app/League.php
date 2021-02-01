<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = [
        'name', 'slug','avatar','', 'about','state_id','city_id','user_id'
    ];

    protected $dates = ['foundation'];

    protected $casts = [
        'foundation'  => 'd/Y'
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function events(){
        return $this->hasMany(Event::class);
    }

    public function user(){
        return  $this->hasOne(User::class);
    }

    public function state(){
        return $this->hasOne(State::class,'id','state_id');
    }

    public function city(){
        return $this->hasOne(City::class,'id','city_id');
    }


}
