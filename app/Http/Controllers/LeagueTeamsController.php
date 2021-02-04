<?php

namespace App\Http\Controllers;

use App\LeagueTeamInvites;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LeagueTeamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
                    'code' => 'required|unique:league_team_invite'
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
            toastr()->error('Ops... esse código já existe');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }
}