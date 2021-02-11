<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventEvaluate;
use App\EventSquad;
use App\LeagueTeam;
use App\ProfileEvent;
use App\Team;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    public function show(Request $request, $id)
    {
        $profile = Auth::user()->profile;
        $event = Event::find($id);

        if ($profile->league->league->id === $event->league->id) {
            $squads = EventSquad::where('event_id', $event->id)->get();
            $subscribers = ProfileEvent::where('event_id', $event->id)->paginate(10);

            $participacao = ProfileEvent::where('event_id', $event->id)->where('profile_id', Auth::user()->profile->id)->first();
            return view('member.league.showEvent', compact('event', 'squads', 'participacao', 'subscribers'));
        }

        toastr()->error('Ops... algo de errado aconteceu');
        return redirect()->back();
    }


    public function showEventsMember()
    {
        $league = Auth::user()->profile->league->league;
        $events = $league->events->sortBy('startdate');
        return view('member.league.events', compact('events'));
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

                    $avatar = $this->uploadAvatar($request, $league);

                    $data['avatar'] = $avatar;

                    $event = Event::create($data);

                    toastr()->success('Evento criado');
                    return redirect()->back();
                }
            } else {
                $avatar = $this->uploadAvatar($request, $league);

                $data['avatar'] = $avatar;

                $event = Event::create($data);

                toastr()->success('Evento criado');
                return redirect()->back();
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (ValidationException $e) {
            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            dd($e);
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    private function uploadAvatar(Request $request, $league)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('avatar')) {

                $avatar = $request->file('avatar');
                $validFile = Validator::make($data, [
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $validFile->validate();

                $avatarName = $league->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();
                $request->avatar->storeAs('avatars', $avatarName);


                return $avatarName;
            }
        } catch (Exception $e) {
            return $e->getMessage();
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

            $subscribers = ProfileEvent::where('event_id', $event->id)->paginate(10);
            $noSquad = ProfileEvent::where('event_id', $event->id)->where('squad_id', null)->get();
            $squads = EventSquad::where('event_id', $event->id)->get();

            return view('league.events.show', compact('event', 'noSquad', 'subscribers', 'squads'));
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

    public function subscribe(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['event_id'] = $data['event'];

            $valid = Validator::make($data, [
                'event_id' => 'required'
            ]);

            $valid->validate();


            $event = Event::find($data['event_id']);

            if ($event->status === 'Aberto') {

                $profile = Auth::user()->profile;
                $hasInscription = ProfileEvent::where('event_id', $data['event_id'])->where('profile_id', $profile->id)->first();

                if ($hasInscription)
                    throw new Error('Já possui inscrição');

                $inscription = ProfileEvent::create([
                    'event_id' => $event->id,
                    'profile_id' => $profile->id
                ]);



                toastr()->success('Inscrição removida');
                return redirect()->back();
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function unSubscribe(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['event_id'] = $data['event'];

            $valid = Validator::make($data, [
                'event_id' => 'required'
            ]);

            $valid->validate();


            $event = Event::find($data['event_id']);

            if ($event->status === 'Aberto') {

                $profile = Auth::user()->profile;
                $inscription = ProfileEvent::where('event_id', $data['event_id'])->where('profile_id', $profile->id)->first();

                if ($inscription)
                    $inscription->delete();

                toastr()->success('Inscrição removida');
                return redirect()->back();
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function openEvent(Request $request, $id)
    {

        try {
            $data = $request->all();


            $valid = Validator::make($data, [
                'event' => 'required'
            ]);

            $valid->validate();

            $profile = Auth::user()->profile;
            $event = Event::find($data['event']);


            if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {



                $event->status = 'Encerrado';
                $event->save();

                toastr()->success('Evento atualizado');
                return redirect()->back();
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function closeEvent(Request $request, $id)
    {
        try {
            $data = $request->all();


            $valid = Validator::make($data, [
                'event' => 'required'
            ]);

            $valid->validate();



            $profile = Auth::user()->profile;
            $event = Event::find($data['event']);


            if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {

                foreach ($event->subscribers as $subscriber) {

                    if ($subscriber->squad_id === null) {
                        toastr()->info('Existem pessoas sem SQUAD');
                        return redirect()->back();
                    }
                }
                $event->status = 'Encerrado';
                $event->save();

                toastr()->success('Evento atualizado');
                return redirect()->back();
            }


            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function finishEvent(Request $request, $id)
    {
        try {
            $data = $request->all();


            $valid = Validator::make($data, [
                'event' => 'required'
            ]);

            $valid->validate();


            $profile = Auth::user()->profile;
            $event = Event::find($data['event']);


            if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {

                $event->status = 'Finalizado';
                $event->save();

                toastr()->success('Evento foi finalizado');
                return redirect()->back();
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function comment(Request $request, $id)
    {
        try {
            $data = $request->all();
            $event = Event::find($id);
            $profile = Auth::user()->profile;

            $inscription = ProfileEvent::where('event_id', $event->id)->where('profile_id', $profile->id)->first();

            $valid = Validator::make($data, [
                'comment' => 'required|string|max:255',
                'star' => 'required|between:1,5'
            ]);

            $valid->validate();
            $data['evaluation'] = $data['star'];

            if ($inscription) {

                $comment = EventEvaluate::create([
                    'event_id' => $inscription->event_id,
                    'profile_id' => $inscription->profile_id,
                    'comment' => $data['comment'],
                    'evaluation' => $data['star']
                ]);

                toastr()->success('Avaliação enviada');
                return redirect()->route('membro-league-show-event', ['id' => $event->id]);
            }
        } catch (ValidationException $e) {
            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            dd($e);
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }
}
