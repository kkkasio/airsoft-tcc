<?php

namespace App\Http\Controllers;

use App\City;
use App\Profile;
use App\State;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class MemberController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();


        $data['slug']     = Str::slug($data['slug'], '-');
        $data['state_id'] = $data['estado'];
        $data['city_id']  = $data['cidade'];
        $data['birthday'] = date("Y-m-d", strtotime(str_replace('/', '-', $data['birthday'])));
        $data['user_id']  = Auth::user()->id;


        $valid =  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'slug' => ['required', 'string', 'max:255', 'unique:profiles'],
            'gender' => ['required', Rule::in(['F', 'M'])],
            "estado" => ['required', 'string'],
            "cidade" => ['required', 'string']

        ]);


        $valid->validate();
        $profile = Profile::create($data);

        toastr()->success('Seu perfil foi criado!');

        return redirect()->route('membro-me');
    }

    public function createView()
    {
        return view('member.create.index');
    }

    public function me()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('member.profile.index', compact('profile', $profile));
    }

    public function editForm()
    {
        $profile = Auth::user()->profile;
        $states = State::all();
        $cities = City::where('state_id', $profile->state_id)->get();

        return view('member.profile.edit.index', compact('profile', 'states', 'cities'));
    }

    public function dashboard()
    {
        return view('member.dashboard');
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $data['birthday'] = date("Y-m-d", strtotime(str_replace('/', '-', $data['birthday'])));


        $valid =  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'gender' => ['required', Rule::in(['F', 'M'])],
            "estado" => ['required', 'string'],
            "cidade" => ['required', 'string']
        ]);

        $valid->validate();

        $auth = Auth::user()->profile;
        $profile = Profile::find($auth->id);

        $profile->update($data);

        toastr()->success('Perfil atualizado');
        return redirect()->route('membro-me');
    }
}
