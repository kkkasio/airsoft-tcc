<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show(Request $request, $id)
    {
        $profile = Auth::user()->profile;
        $event = Event::find($id);


        if($profile->league->league->id === $event->league->id){
            return view('member.league.showEvent',compact('event'));
        }

        toastr()->error('Ops... algo de errado aconteceu');
        return redirect()->back();
    }
}
