<?php

namespace App\Http\Controllers;

use App\Event;
use App\LeagueTeam;
use App\Team;
use Carbon\Carbon;
use Exception;
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
        try {
            $data = $request->all();
            $league = Auth::user()->league;

            $data['league_id'] = $league->id;
            $data['startdate'] = Carbon::createFromDate($data['startdate']);
            $data['enddate']   = Carbon::createFromDate($data['enddate']);
            $data['team_id']   = $data['time'];
            $data['type']      = 'Jogo';

            $valid = Validator::make($data, [
                'name' => 'required|string|min:3',
                'players' => 'required|integer',
                'about' => 'required|string|min:3',
                'status' => 'required|string|min:3',
                'team_id' => 'required|integer',
                'startdate' => 'required|date', 'before:today',
                'enddate' => 'required|date', 'before:today|after:startdate'
            ]);

            $valid->validate();

            $data['team_id'] = $data['time'] > 0 ? $data['time'] : null;


            if ($data['team_id']) {
                $team = Team::find($data['team_id']);
                if ($team->league->league->id === $data['league_id']) {
                    $event = Event::create($data);

                    toastr()->success('Evento criado');
                    return redirect()->back();
                }
            } else {
                $event = Event::create($data);

                toastr()->success('Evento criado');
                return redirect()->back();
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function allLeague(Request $request)
    {
        $league = Auth::user()->league;

        $planned  = $league->events->where('status', 'Planejado')->sortBy('startdate')->slice(0, 4);
        $open  = $league->events->where('status', 'Aberto')->sortBy('startdate')->slice(0, 4);
        $close  = $league->events->where('status', 'Encerrado')->sortBy('startdate')->slice(0, 4);


        return view('league.events.all', compact('planned', 'open', 'close'));
    }

    public function showLeague($id)
    {
        $league = Auth::user()->league;
        $event = Event::findOrFail($id);

        if ($event->league_id === $league->id) {

            dd($event);
        }

        toastr()->error('Ops... ago de errado aconteceu');
        return redirect()->back();
    }

    public function open()
    {
        $league = Auth::user()->league;
        $open  = $league->events->where('status', 'Aberto')->sortBy('startdate');

        return view('league.events.open.index', compact('open'));
    }

    public function planned()
    {
        $league = Auth::user()->league;
        $planned  = $league->events->where('status', 'Planejado')->sortBy('startdate');

        return view('league.events.planned.index', compact('planned'));
    }
}
