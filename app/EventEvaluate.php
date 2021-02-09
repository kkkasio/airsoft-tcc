<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventEvaluate extends Model
{
    protected $table = 'evaluate_event';
    protected $fillable = ['profile_id','event_id','comment','evaluation'];


    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);

    }
}
