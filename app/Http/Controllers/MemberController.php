<?php

namespace App\Http\Controllers;

use App\City;
use App\Profile;
use App\ProfileEvent;
use App\ProfileTeam;
use App\State;
use App\TeamInvite;
use Carbon\Carbon;
use Exception;
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


        $todaySub18Years = Carbon::now()->subYears(18)->format('d/m/Y');


        $messages = [
            'birthday.before_or_equal' => 'Você deve ter 18 anos',
            'estado.*' => 'Você deve selecionar um estado',
            'cidade.*' => 'Você deve selecionar uma cidade',
        ];

        $valid =  Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'nickname' => ['required', 'string', 'min:4', 'max:255'],
            'birthday' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:' . $todaySub18Years],
            'slug' => ['required', 'string', 'min:4', 'max:255', 'unique:profiles'],
            'gender' => ['required', Rule::in(['F', 'M'])],
            "estado" => ['required', 'integer',],
            "cidade" => ['required', 'integer']

        ], $messages);


        $valid->validate();
        $profile = Profile::create($data);

        $avatar = $this->uploadAvatar($request, $profile);

        if ($avatar) {
            $data['avatar'] = $avatar;
            $profile->update($data['avatar']);
        }

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

    public function show($slug)
    {
        $member = Profile::where('slug', $slug)->firstOrFail();

        return view('member.profile.member', compact('member'));
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
        $league = Auth::user()->profile->league;
        $team = Auth::user()->profile->team;

        $events = ProfileEvent::where('profile_id', Auth::user()->profile->id)->get();

        return view('member.dashboard', compact('league', 'team', 'events'));
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

        $data['city_id'] = $data['cidade'];
        $data['state_id'] = $data['estado'];

        $auth = Auth::user()->profile;
        $profile = Profile::find($auth->id);


        $avatar = $this->uploadAvatar($request, $profile);

        if ($avatar) {
            $data['avatar'] = $avatar;
        }

        $profile->update($data);

        toastr()->success('Perfil atualizado');
        return redirect()->route('membro-me');
    }

    private function uploadAvatar(Request $request, $profile)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('avatar')) {

                $avatar = $request->file('avatar');
                $validFile = Validator::make($data, [
                    'avatar' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
                ]);

                $validFile->validate();

                $avatarName = $profile->id . '_avatar_p' . time() . '.' . $avatar->getClientOriginalExtension();
                $request->avatar->storeAs('avatars', $avatarName);


                return $avatarName;
            }
            return null;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function inviteTeamForm()
    {
        $profile = Auth::user()->profile;


        if ($profile->team) {
            toastr()->error('Ops... Você já tem um time');
            return redirect()->back();
        }

        return view('member.team.invite.index');
    }

    public function invitePost(Request $request)
    {

        try {
            $data = $request->all();
            $profile = Auth::user()->profile;

            $valid = Validator::make($data, [
                // 'code'  => 'exists:team_invites'
            ]);

            $valid->validate();


            if (!$profile->team) {

                $invite = TeamInvite::where('code', $data['code'])->first();
                $invite->used = true;
                $invite->profile_id = $profile->id;
                $invite->save();


                ProfileTeam::create([
                    'profile_id' => $profile->id,
                    'team_id' => $invite->team_id,
                    'type' => 'Membro'
                ]);

                toastr()->success('Você entrou no time');
                return redirect()->route('membro-time-show', ['slug' => $invite->team->slug]);
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

    public function leagueLogin()
    {
        try {
            $profile = Auth::user()->profile;
            $league = Auth::user()->profile->league;

            if ($league->type !== 'Moderador') {
                throw new Exception('Ops... você não é um moderador');
            }

            $user = $league->league->user;
            Auth::login($user);

            toastr('Login realizado com sucesso', 'success');
            return redirect()->route('liga-dashboard');
        } catch (Exception $e) {
            toastr('Ops... ocorreu um erro', 'error');
            return redirect()->back();
        }
    }
    public function formPassword()
    {
        $user = Auth::user();
        return view('auth.passwords.change', compact('user'));
    }
}
