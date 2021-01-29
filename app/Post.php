<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content', 'league_id'
    ];


    public function league(){
        return $this->belongsTo(League::class);
    }
}
