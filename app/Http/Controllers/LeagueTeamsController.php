<?php

namespace App\Http\Controllers;

use App\LeagueTeam;
use App\LeagueTeamInvites;
use App\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LeagueTeamsController extends Controller
{

    public function show()
    {
        $league = Auth::user()->league;
        return view('league.teams.index', compact('league'));
    }

    public function showInvites()
    {
        $league = Auth::user()->league;
        $invites = LeagueTeamInvites::where('league_id', $league->id)->get();

        return view('league.teams.invite.index', compact('invites'));
    }

    public function create(Request $request)
    {

        try {
            $data = $request->all();

            $league = Auth::user()->league;
            $data['league_id'] = $league->id;
            $data['code'] = strtoupper(str_replace(' ', '', $data['code']));

            if ($data['code']) {
                $valid = Validator::make($data, [
                    'code' => 'required|unique:league_team_invite|min:5'
                ]);

                $valid->validate();

                $invite = LeagueTeamInvites::create($data);

                toastr()->success('Código criado!');
                return redirect()->route('liga-times-show-invites');
            } else {
                $data['code'] = strtoupper(uniqid());

                $invite = LeagueTeamInvites::create($data);

                toastr()->success('Código cirado!');
                return redirect()->route('liga-times-show-invites');
            }
        } catch (ValidationException $e) {

            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function deleteInvite(Request $request, $id)
    {
        $invite = LeagueTeamInvites::findOrFail($id);


        if ($invite->team_id) {
            toastr('Ops... esse convite já foi utilizado', 'error');
            return redirect()->back();
        }

        $invite->delete();
        toastr('Convite removido com sucesso!', 'success');
        return redirect()->back();
    }

    public function membersTeam($slug)
    {
        $team = Team::where('slug', $slug)->first();
        $league = Auth::user()->league;

        $teamLeague = LeagueTeam::where('team_id', $team->id)->where('league_id', $league->id)->first();

        if ($teamLeague) {
            return view('league.teams.members.index', compact('teamLeague'));
        }
        toastr()->error('Ops... algo de errado aconteceu');
        return redirect()->back();
    }
}
