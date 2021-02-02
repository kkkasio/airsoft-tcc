<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:teams',
            'about' => 'required|string'
        ]);

        $valid->validate();

        $team = Team::create($data);

        //adicionar membro ao
        $addMember = Team::find($team->id)->members()->attach(Auth::user()->profile->id);

        return redirect()->route('membro-time-show', ['slug' => $team->slug]);
    }

    public function show(Request $request, $slug)
    {

        $team = Team::where('slug', '=', $slug)->firstOrFail();

        return view('team.show.index', compact($team, 'team'));
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

            return redirect()->back();
        } catch (Exception $e) {
            dd($e->getMessage());
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

            $result = DB::select('SELECT * FROM team_members WHERE profile_id = :profile_id LIMIT 1', ['profile_id' => $profile_id]);
            $isModerador = $result[0];

            if ($isModerador->team_id === $team->id && $isModerador->type === 'Moderador') {

                $result_member = DB::select('SELECT * FROM team_members WHERE id = :id LIMIT 1', ['id' => $id]);
                $member = $result_member[0];
                $profile = Profile::find($member->profile_id);


                return view('team.edit.member.edit', compact('member', 'profile'));
            }
        } catch (Exception $e) {
            dd($e);
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function memberUpdate(Request $request, $slug, $id)
    {
        $data = $request->all();

        $valid = Validator::make($data, [
            'type' => ['required', Rule::in(['Moderador','Membro'])]
        ]);

        $valid->validate();

        try {
            $team = Team::where('slug', $slug)->first();
            $profile_id = Auth::user()->profile->id;

            $result = DB::select('SELECT * FROM team_members WHERE profile_id = :profile_id LIMIT 1', ['profile_id' => $profile_id]);
            $isModerador = $result[0];

            if ($isModerador->team_id === $team->id && $isModerador->type === 'Moderador') {

                $isOwner = DB::table('team_members')->where('id',$id)->first();
                if($team->profile_id === $isOwner->profile_id){
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
}
