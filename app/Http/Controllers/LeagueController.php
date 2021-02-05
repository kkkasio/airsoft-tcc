<?php

namespace App\Http\Controllers;

use App\League;
use App\ProfileLeague;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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

    public function showEventsMember()
    {
        $league = Auth::user()->profile->league->league;
        $events = $league->events->sortDesc();
        return view('member.league.events', compact('events'));
    }

    public function showMembers(){
        $league = Auth::user()->league;

        $members = ProfileLeague::where('league_id',$league->id)->get();

        return view('league.members.show',compact('members'));
    }
}
