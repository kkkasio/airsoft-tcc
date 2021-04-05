<?php

namespace App\Http\Controllers;

use App\Event;
use App\LeagueTeam;
use App\LeagueTeamInvites;
use App\Profile;
use App\ProfileLeague;
use App\ProfileTeam;
use App\Team;
use App\TeamInvite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;

class TeamController extends Controller
{
    public function showCreate()
    {
        return view('team.create.index');
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $data['profile_id'] = Auth::user()->profile->id;

        $valid = Validator::make($data, [
            'name' => 'required|string|max:255|min:4',
            'slug' => 'required|string|unique:teams|min:4',
            'about' => 'required|string'
        ]);

        $valid->validate();

        $team = Team::create($data);

        $data['profile_id'] = Auth::user()->profile->id;
        $data['team_id'] = $team->id;
        $data['type'] =  'Moderador';
        //adicionar membro ao
        $addMember = Team::find($team->id)->members()->create($data);

        return redirect()->route('membro-time-show', ['slug' => $team->slug]);
    }

    public function show(Request $request, $slug)
    {

        $team = Team::where('slug', '=', $slug)->firstOrFail();

        $events = Event::where('team_id', $team->id)->paginate(5);

        return view('team.show.index', compact('team', 'events'));
    }

    public function editForm(Request $request, $slug)
    {
        try {

            $team = Team::where('slug', $slug)->first();
            $profile_id = Auth::user()->profile->id;
            $result = DB::select('SELECT * FROM team_members WHERE profile_id = :profile_id LIMIT 1', ['profile_id' => $profile_id]);

            $isModerador = $result[0];

            $members = $team->members;

            if ($isModerador->team_id === $team->id) {
                return view('team.edit.index', compact('team', 'members'));
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $slug)
    {

        try {
            $data = $request->all();
            $team = Team::where('slug', $slug)->first();
            $profile_id = Auth::user()->profile->id;

            $result = DB::select('SELECT * FROM team_members WHERE profile_id = :profile_id LIMIT 1', ['profile_id' => $profile_id]);
            $isModerador = $result[0];

            if ($isModerador->team_id === $team->id && $isModerador->type === 'Moderador') {
                $team->update($data);
                toastr()->success('O time foi atualizado!');
                return redirect()->back();
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function memberEdit(Request $request, $slug, $id)
    {

        try {
            $team = Team::where('slug', $slug)->first();
            $profile_id = Auth::user()->profile->id;

            $isModerador = ProfileTeam::where('profile_id', $profile_id)->first();

            if ($isModerador->team_id === $team->id && $isModerador->type === 'Moderador') {

                $member = ProfileTeam::where('id', $id)->first();
                $profile = Profile::find($member->profile_id);

                return view('team.edit.member.edit', compact('member', 'profile'));
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function memberUpdate(Request $request, $slug, $id)
    {
        $data = $request->all();

        $valid = Validator::make($data, [
            'type' => ['required', Rule::in(['Moderador', 'Membro'])]
        ]);

        $valid->validate();

        try {
            $team = Team::where('slug', $slug)->first();
            $profile_id = Auth::user()->profile->id;

            $result = DB::select('SELECT * FROM team_members WHERE profile_id = :profile_id LIMIT 1', ['profile_id' => $profile_id]);
            $isModerador = $result[0];

            if ($isModerador->team_id === $team->id && $isModerador->type === 'Moderador') {

                $isOwner = DB::table('team_members')->where('id', $id)->first();
                if ($team->profile_id === $isOwner->profile_id) {
                    throw new Exception('Você não pode editar o dono do time');
                }

                $result = DB::table('team_members')->where('id', $id)->update(['type' => $data['type']]);

                toastr()->success('O Membro foi atualizado');
                return redirect()->route('membro-time-show', ['slug' => $team->slug]);
            }
        } catch (ValidationException $exception) {
            return redirect()->back()->withErrors($exception->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error('Ops.. algo de errado aconteceu...');
            return redirect()->back();
        }
    }

    public function invitePost(Request $request, $slug)
    {
        try {
            $data = $request->all();
            $valid = Validator::make($data, [
                'code' => 'required|string'
            ]);

            $valid->validate();

            $code = LeagueTeamInvites::where('code', '=', $data['code'])->first();


            if ($code) {
                if ($code->used || $code->team_id) {
                    throw new Exception('Código já foi utilizado');
                }

                $team = Team::where('slug', $slug)->first();

                foreach ($team->members as $member) {
                    ProfileLeague::updateOrCreate([
                        'profile_id' => $member->profile_id,
                        'league_id' => $code->league_id,
                        'type' => 'Membro'
                    ]);
                }

                LeagueTeam::create([
                    'team_id' => $team->id,
                    'league_id' => $code->league_id
                ]);



                $code->used = true;
                $code->team_id = $team->id;
                $code->save();

                toastr()->success('Time adicionado na liga ' . $code->league->name);
                return redirect()->back();
            }

            toastr()->warning('Código não encontrado');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo deu errado');
            return redirect()->back();
        }
    }

    public function memberRemove(Request $request, $slug, $id)
    {
        try {
            $member = ProfileTeam::find($id);
            $profile = Auth::user()->profile;
            $team = Team::where('slug', $slug)->first();

            $member = ProfileTeam::where('id', $id)->first();


            $isModerador = ProfileTeam::where('profile_id', $profile->id)->first();

            if ($isModerador->team_id === $member->team_id && $isModerador->type === 'Moderador') {


                if ($team->members->count() === 1 || $team->profile_id === $member->profile_id) {
                    toastr()->error('Ops... você não pode excluir este membro');
                    return redirect()->back();
                }


                $profile = Profile::find($member->profile_id);
                $member->delete();

                toastr()->success('Membro removido do time');
                return redirect()->route('membro-time-show', ['slug' => $team->slug]);
            }
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function showCodeInvite(Request $request, $slug)
    {
        try {
            $team = Team::where('slug', $slug)->first();
            $profile = Auth::user()->profile;

            if ($profile->team && $profile->team->type === 'Moderador' && $profile->team->team->id === $team->id) {

                $invites = TeamInvite::where('team_id', $team->id)->get();

                return view('team.invites.index', compact('invites', 'team'));
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function codeInvite(Request $request, $slug)
    {
        try {
            $data = $request->all();
            $team = Team::where('slug', $slug)->first();

            $data['code'] = strtoupper(str_replace(' ', '', $data['code']));
            $data['team_id'] = $team->id;

            if ($data['code']) {
                $valid = Validator::make($data, [
                    'code' => 'required|unique:team_invites|min:5'
                ]);

                $valid->validate();

                $invite = TeamInvite::create($data);

                toastr()->success('Código criado!');
                return redirect()->back();
            } else {
                $data['code'] = strtoupper(uniqid());

                $invite = TeamInvite::create($data);

                toastr()->success('Código cirado!');
                return redirect()->back();
            }
        } catch (ValidationException $e) {

            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function removeInvite(Request $request, $id)
    {
        $invite = TeamInvite::findOrFail($id);


        if ($invite->profile_id) {
            toastr('Ops... esse convite já foi utilizado', 'error');
            return redirect()->back();
        }

        $invite->delete();
        toastr('Convite removido com sucesso!', 'success');
        return redirect()->back();
    }

    public function exportMembers()
    {

        try {
            $profile = Auth::user()->profile;


            if ($profile->team) {
                $team = Team::find($profile->team->team_id);
                $members = $team->members;


                $pdf = PDF::loadView('pdf.team', compact('members'));


                return $pdf->stream('customers.pdf');
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
        }
    }
}
