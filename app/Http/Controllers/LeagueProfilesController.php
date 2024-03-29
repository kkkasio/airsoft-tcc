<?php

namespace App\Http\Controllers;

use App\LeagueProfileInvites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LeagueProfilesController extends Controller
{
    public function showInvites()
    {
        $league = Auth::user()->league;
        $invites = LeagueProfileInvites::where('league_id', $league->id)->orderBy('created_at', 'desc')->paginate(15);

        return view('league.members.invite.index', compact('invites'));
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
                    'code' => 'required|unique:league_profile_invite|min:5'
                ]);

                $valid->validate();

                $invite = LeagueProfileInvites::create($data);

                toastr()->success('Código criado!');
                return redirect()->route('liga-members-show-invites');
            } else {
                $data['code'] = strtoupper(uniqid());

                $invite = LeagueProfileInvites::create($data);

                toastr()->success('Código cirado!');
                return redirect()->route('liga-members-show-invites');
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
        $invite = LeagueProfileInvites::findOrFail($id);

        if ($invite->profile_id) {
            toastr('Ops... esse convite já foi utilizado', 'error');
            return redirect()->back();
        }

        $invite->delete();
        toastr('Convite removido com sucesso!', 'success');
        return redirect()->back();
    }
}
