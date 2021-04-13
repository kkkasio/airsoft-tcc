<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventEvaluate;
use App\EventSquad;
use App\LeagueTeam;
use App\Profile;
use App\ProfileEvent;
use App\Team;
use App\Weapon;
use App\WeaponInscription;
use PDF;
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
        $event = Event::findOrFail($id);

        if ($profile->league->league->id === $event->league->id) {
            $squads = EventSquad::where('event_id', $event->id)->get();
            $subscribers = ProfileEvent::where('event_id', $event->id)->paginate(10);

            $participacao = ProfileEvent::where('event_id', $event->id)->where('profile_id', Auth::user()->profile->id)->first();
            return view('member.league.showEvent', compact('event', 'squads', 'participacao', 'subscribers'));
        }

        toastr()->error('Ops... algo de errado aconteceu');
        return redirect()->back();
    }

    public function showinscricao($id, $inscricao)
    {
        $inscricao = ProfileEvent::findOrFail($inscricao);
        $weapons = $inscricao->profile->weapons;

        if (Auth::user()->type === 'Liga') {
            return view('league.events.inscription', compact('inscricao', 'weapons'));
        } else {
            return view('member.league.inscription', compact('inscricao', 'weapons'));
        }
    }

    public function inscricaoWeapon(Request $request, $id, $inscricao)
    {
        $data = $request->all();

        try {

            $event = Event::findOrFail($id);
            $inscricao = ProfileEvent::findOrFail($inscricao);
            $weapon = Weapon::findOrFail($data['weapon']);

            $hasWeaponInscription = WeaponInscription::where('inscription_id', $inscricao->id)->where('weapon_id', $weapon->id)->first();
            if ($hasWeaponInscription) {
                throw new Exception('Ops.. essa arma já está cronada!');
            }

            if (!$weapon || !$weapon->profile_id === $inscricao->profile_id) {
                throw new Exception('Ops.. ocoreu um erro ao buscar a arma');
            }


            $data['inscription_id'] = $inscricao->id;
            $data['weapon_id'] = $data['weapon'];


            $valid = Validator::make($data, [
                'inscription_id' => 'required|integer',
                'weapon_id'      => 'required|integer',
                'fps'            => 'required|integer',
                'note'           => 'sometimes|nullable|string',

            ]);
            $valid->validate();

            WeaponInscription::create($data);

            toastr()->success('Arma cronada com sucesso!');
            return redirect()->back();
        } catch (ValidationException $e) {
            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function removeWeaponInscription(Request $request)
    {
        $data = $request->all();

        $weaponInscription = WeaponInscription::findOrFail($data['weapon']);
        $weaponInscription->delete();

        toastr()->success('A cronagem foi removida');
        return redirect()->back();
    }


    public function showEventsMember()
    {
        $league = Auth::user()->profile->league->league;

        $events = Event::where('league_id', $league->id)->where('startdate', '>', Carbon::now()->subDay())->open()->orderBy('startdate')->get();

        $closedEvents = Event::where('league_id', $league->id)->where('status', 'Finalizado')->orWhere('status', 'Cancelado')->orderBy('startdate', 'desc')->get();

        return view('member.league.events', compact('events', 'closedEvents'));
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

            $dateEvent = Carbon::createFromDate($data['startdate'])->format('Y-m-d');

            $data['league_id'] = $league->id;
            $data['startdate'] = Carbon::createFromDate($data['startdate']);
            $data['enddate']   = Carbon::createFromDate($data['enddate']);
            $data['team_id']   = $data['time'];
            $data['type']      = 'Jogo';
            $data['eventdate'] = $dateEvent;


            $valid = Validator::make($data, [
                'name' => 'required|string|min:3',
                'players' => 'required|integer',
                'about' => 'required|string|min:3',
                'status' => 'required|string|min:3',
                'team_id' => 'required|integer',
                'startdate' => 'required|date', 'before:today',
                'enddate' => 'required|date', 'before:today|after_or_equal:startdate'
            ]);

            $valid->validate();

            $data['team_id'] = $data['time'] > 0 ? $data['time'] : null;


            if ($data['team_id']) {
                $team = Team::find($data['team_id']);
                if ($team->league->league->id === $data['league_id']) {

                    $pdf = $this->uploadPdf($request, $league);
                    $avatar = $this->uploadAvatar($request, $league);

                    if ($avatar) {
                        $data['avatar'] = $avatar;
                    }

                    if ($pdf) {
                        $data['file'] = $pdf;
                    }
                    $event = Event::create($data);

                    toastr()->success('Evento criado');
                    return redirect()->back();
                }
            } else {
                $pdf = $this->uploadPdf($request, $league);
                $avatar = $this->uploadAvatar($request, $league);

                if ($avatar) {
                    $data['avatar'] = $avatar;
                }

                if ($pdf) {
                    $data['file'] = $pdf;
                }

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
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back()->withInput();
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

        $planned = Event::where('league_id', $league->id)->where('status', 'Planejado')->orderBy('startdate', 'DESC')->get();
        $open  = Event::where('league_id', $league->id)->where('status', 'Aberto')->orderBy('startdate', 'DESC')->get();
        $finish  = Event::where('league_id', $league->id)->where('status', 'Finalizado')->orWhere('status', 'Cancelado')->orderBy('startdate', 'asc')->get();


        return view('league.events.all', compact('planned', 'open', 'finish'));
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
            toastr()->error('Ops... algo de errado acontece u');
            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
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


            if (Auth::user()->type === 'Liga') {
                $league = Auth::user()->league;
                $event = Event::find($data['event']);


                if ($event->league_id === $league->id && !$event->team) {

                    $event->status = 'Aberto';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            } else {

                $profile = Auth::user()->profile;
                $event = Event::find($data['event']);


                if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {

                    $event->status = 'Aberto';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
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


            if (Auth::user()->type === 'Liga') {
                $league = Auth::user()->league;
                $event = Event::find($data['event']);


                if ($event->league_id === $league->id && !$event->team) {


                    $event->status = 'Finalizado';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            } else {

                $profile = Auth::user()->profile;
                $event = Event::find($data['event']);


                if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {

                    $event->status = 'Finalizado';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            }





            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function finishInscription(Request $request, $id)
    {
        try {
            $data = $request->all();


            $valid = Validator::make($data, [
                'event' => 'required'
            ]);

            $valid->validate();


            if (Auth::user()->type === 'Liga') {
                $league = Auth::user()->league;
                $event = Event::find($data['event']);


                if ($event->league_id === $league->id && !$event->team) {

                    /*foreach ($event->subscribers as $subscriber) {

                        if ($subscriber->squad_id === null) {
                            toastr()->info('Existem pessoas sem SQUAD');
                            return redirect()->back();
                        }
                    }*/


                    if ((count($event->subscribers) < $event->players)) {

                        $event->status = 'Cancelado';
                        $event->save();

                        toastr()->warning('Evento foi Cancelado. Não possui o mínimo de jogadores necessários');

                        return redirect()->back();
                    }

                    $event->status = 'Inscrições Encerradas';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            } else {

                $profile = Auth::user()->profile;
                $event = Event::find($data['event']);


                if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {

                    if ((count($event->subscribers) < $event->players)) {

                        $event->status = 'Cancelado';
                        $event->save();

                        toastr()->warning('Evento foi Cancelado. Não possui o mínimo de jogadores necessários');

                        return redirect()->back();
                    }

                    $event->status = 'Inscrições Encerradas';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception  $e) {
            dd($e);
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function finishTeams(Request $request, $id)
    {
        try {
            $data = $request->all();


            $valid = Validator::make($data, [
                'event' => 'required'
            ]);

            $valid->validate();


            if (Auth::user()->type === 'Liga') {
                $league = Auth::user()->league;
                $event = Event::find($data['event']);


                if ($event->league_id === $league->id && !$event->team) {

                    foreach ($event->subscribers as $subscriber) {

                        if ($subscriber->squad_id === null) {
                            toastr()->info('Existem pessoas sem SQUAD');
                            return redirect()->back();
                        }
                    }

                    if (count($event->squads) <= 1) {

                        toastr()->info('É obrigatório ter mais de um SQUAD');
                        return redirect()->back();
                    }

                    if ((count($event->subscribers) < $event->players)) {

                        $event->status = 'Cancelado';
                        $event->save();

                        toastr()->warning('Evento foi Cancelado. Não possui o mínimo de jogadores necessários');
                        return redirect()->back();
                    }

                    $event->status = 'Times Divididos';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            } else {

                $profile = Auth::user()->profile;
                $event = Event::find($data['event']);


                if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {

                    foreach ($event->subscribers as $subscriber) {

                        if ($subscriber->squad_id === null) {
                            toastr()->info('Existem pessoas sem SQUAD');
                            return redirect()->back();
                        }
                    }

                    if (count($event->squads) <= 1) {

                        toastr()->info('É obrigatório ter mais de um SQUAD');
                        return redirect()->back();
                    }

                    if ((count($event->subscribers) < $event->players)) {

                        $event->status = 'Cancelado';
                        $event->save();

                        toastr()->warning('Evento foi Cancelado. Não possui o mínimo de jogadores necessários');
                        return redirect()->back();
                    }

                    $event->status = 'Times Divididos';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception  $e) {
            dd($e);
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


            if (Auth::user()->type === 'Liga') {
                $league = Auth::user()->league;
                $event = Event::find($data['event']);


                if ($event->league_id === $league->id && !$event->team) {

                    $event->status = 'Finalizado';
                    $event->save();

                    toastr()->success('Evento atualizado');
                    return redirect()->back();
                }
            } else {

                $profile = Auth::user()->profile;
                $event = Event::find($data['event']);


                if ($profile->team && $profile->team->team && $profile->team->type === 'Moderador' && $event->team_id === $profile->team->team->id) {

                    $event->status = 'Finalizado';
                    $event->save();

                    toastr()->success('Evento foi finalizado');
                    return redirect()->back();
                }
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

            toastr()->error('Ops... Você não está inscrito no evento.');
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

    public function formEdit($id)
    {
        $user  =  Auth::user();
        $event = Event::findOrFail($id);

        if ($user->type === 'Membro') {
            if ($user->can('manage-event', $event)) {
                $profile  =  $user->profile;

                return view('member.league.editEvent', compact('event'));
            }
        } else if ($user->type === 'Liga') {
            $league = Auth::user()->league;
            $teams =  LeagueTeam::where('league_id', $league->id)->get();

            if ($event->league_id === $league->id && !in_array($event->status, ['Cancelado', 'Finalizado'])) {

                return view('league.events.edit.index', compact('event', 'teams'));
            }
        }
        return  redirect('404');
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $event = Event::findOrFail($id);
            $league = Auth::user()->league;


            $data['league_id'] = $league->id;
            $data['startdate'] = Carbon::createFromDate($data['startdate']);
            $data['enddate']   = Carbon::createFromDate($data['enddate']);
            $data['team_id']   = $data['time'];
            $data['type']      = 'Jogo';
            $data['eventdate'] = $data['startdate']->format('Y-m-d');


            $dayEvent = Event::whereDate('eventdate', $data['startdate']->format('Y-m-d'))->first();


            if ($dayEvent && !$dayEvent->id === $event->id) {
                throw new Exception('Já existe um evento criado para esse dia!');
            }

            $valid = Validator::make($data, [
                'name' => 'required|string|min:3',
                'startdate' => 'required|date', 'before:today',
                'enddate' => 'required|date', 'before:today|after:startdate',
                'players' => 'required|integer',
                'about' => 'required|string|min:3',
                'status' => 'required|string|min:3',
                'team_id' => 'required|integer'
            ]);

            $valid->validate();

            $data['team_id'] = $data['time'] > 0 ? $data['time'] : null;


            if ($data['team_id']) {
                $team = Team::find($data['team_id']);
                if ($team->league->league->id === $data['league_id']) {

                    $pdf = $this->uploadPdf($request, $league);
                    $avatar = $this->uploadAvatar($request, $league);


                    if ($avatar) {
                        $data['avatar'] = $avatar;
                    }


                    if ($pdf) {
                        $data['file'] = $pdf;
                    }

                    $event->update($data);

                    toastr()->success('Evento Atualizado');
                    return redirect()->back();
                }
            } else {
                $pdf = $this->uploadPdf($request, $league);
                $avatar = $this->uploadAvatar($request, $league);

                if ($avatar) {
                    $data['avatar'] = $avatar;
                }

                if ($pdf) {
                    $data['file'] = $pdf;
                }

                $event->update($data);

                toastr()->success('Evento Atualizado');
                return redirect()->back();
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (ValidationException $e) {
            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function memberUpdate(Request $request, $id)
    {
        try {
            $data = $request->all();
            $event = Event::findOrFail($id);
            $profile = Auth::user()->profile;



            $data['league_id'] = $profile->league->league_id;
            $data['startdate'] = Carbon::createFromDate($data['startdate']);
            $data['enddate']   = Carbon::createFromDate($data['enddate']);
            $data['type']      = 'Jogo';

            $valid = Validator::make($data, [
                'name' => 'required|string|min:3',
                'startdate' => 'required|date', 'before:today',
                'enddate' => 'required|date', 'before:today|after:startdate',
                'players' => 'required|integer',
                'about' => 'required|string|min:3',
                'status' => 'required|string|min:3',
            ]);

            $valid->validate();

            $pdf = $this->uploadPdf($request, $profile->league->league_id);
            $avatar = $this->uploadAvatar($request, $profile->league->league_id);


            if ($avatar) {
                $data['avatar'] = $avatar;
            }


            if ($pdf) {
                $data['file'] = $pdf;
            }

            $event->update($data);

            toastr()->success('Evento Atualizado');
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

    private function uploadPdf(Request $request, $league)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('file')) {

                $pdf = $request->file('file');

                $validFile = Validator::make($data, [
                    "file" => "required|mimetypes:application/pdf|max:10000"

                ]);

                $validFile->validate();

                $pdfName = $league->id . '_pdf' . time() . '.' . request()->file->getClientOriginalExtension();


                $request->file->storeAs('files', $pdfName);


                return $pdfName;
            }
            return null;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function exportSquads($id)
    {
        $event = Event::findOrFail($id);

        try {

            $pdf = PDF::loadView('pdf.event', compact('event'));

            return $pdf->stream('event.pdf');
        } catch (Exception $e) {
            dd($e);
        }
    }
}
