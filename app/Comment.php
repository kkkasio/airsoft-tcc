<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'profile_id', 'about',
    ];


    public function event(){
        return $this->belongsTo(Event::class);
    }
}
