<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = [
        'name', 'slug', 'about',
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
}
