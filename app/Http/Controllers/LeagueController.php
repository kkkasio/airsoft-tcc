<?php

namespace App\Http\Controllers;

use App\League;
use App\LeagueProfileInvites;
use App\ProfileLeague;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LeagueController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        dd('ok');
    }

    public function dashboard()
    {
        return view('league.dashboard');
    }

    public function createView()
    {
        return view('league.create.index');
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $data['slug'] =  Str::slug($data['slug'], '-');
        $data['state_id'] = $data['estado'];
        $data['city_id'] = $data['cidade'];
        $data['slug'] =  Str::slug($data['slug'], '-');
        $data['foundation'] = date("Y-m-d", strtotime($data['foundation']));
        $data['user_id'] = Auth::user()->id;


        $valid =  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:leagues'],
            'foundation' => ['required', 'date_format:Y-m-d'],
            "estado" => ['required', 'string'],
            "cidade" => ['required', 'string'],
            "about" => ['required', 'string']
        ]);


        $valid->validate();

        $league = League::create($data);

        return redirect()->route('liga-me');
    }

    public function me(Request $request)
    {
        $user = Auth::user();
        $league = $user->league;
        return view('league.profile.index', compact('league', $league));
    }

    public function meEditForm()
    {
        return view();
    }

    public function editForm()
    {
        return view('league.posts.edit');
    }
    public function update(Request $request)
    {
        dd($request);
    }

    public function showPostsMember()
    {

        $league = Auth::user()->profile->league->league;
        $posts = $league->posts->sortDesc();

        return view('member.league.posts', compact('posts'));
    }

    public function showMembers()
    {
        $league = Auth::user()->league;
        $members = ProfileLeague::where('league_id', $league->id)->get();
        return view('league.members.show', compact('members'));
    }

    public function inviteMember(Request $request)
    {
        try {
            $data = $request->all();

            $valid = Validator::make($data, [
                'code'  => 'exists:league_profile_invite'
            ]);

            $valid->validate();

            $profile = Auth::user()->profile;

            if (!$profile->league) {

                $invite = LeagueProfileInvites::where('code', $data['code'])->first();
                $invite->used = true;
                $invite->profile_id = $profile->id;

                ProfileLeague::updateOrCreate([
                    'profile_id' => $profile->id,
                    'league_id' => $invite->league_id,
                    'type' => 'Membro'
                ]);

                $invite->save();

                toastr()->success('Você foi adicionado na liga');
                return redirect()->back();
            }


            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (ValidationException $e) {
            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
}
