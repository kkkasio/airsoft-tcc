<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'slug', 'about','owner_id'
    ];


    public function members(){
        return $this->hasMany(Profile::class);
    }
}
