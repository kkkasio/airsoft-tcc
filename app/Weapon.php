<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $fillable = [
        'name','nickname','avatar', 'type', 'profile_id',
    ];




    public function profile(){
        return $this->belongsTo(Profile::class);
    }


}
