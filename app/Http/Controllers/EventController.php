<?php

namespace App\Http\Controllers;

use App\Event;
use App\LeagueTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class EventController extends Controller
{
    public function show(Request $request, $id)
    {
        $profile = Auth::user()->profile;
        $event = Event::find($id);


        if ($profile->league->league->id === $event->league->id) {
            return view('member.league.showEvent', compact('event'));
        }

        toastr()->error('Ops... algo de errado aconteceu');
        return redirect()->back();
    }

    public function createForm()
    {
        $league = Auth::user()->league;
        $teams = LeagueTeam::where('league_id', $league->id)->get();

        return view('league.events.create.index', compact('teams'));
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $league = Auth::user()->league;

        $data['league_id'] = $league->id;

        $valid = Validator::make($data,[
            'name' => 'required|string|min:3',
            'players' => 'required|integer',
            'about' => 'required|string|min:3',
            'status' => 'required|string|min:3',
            'date' => 'required|date_format:Y-m-d','before:today',
            'type' => 'required'
        ]);

        dd($data);

        $valid->validate();
    }
}
