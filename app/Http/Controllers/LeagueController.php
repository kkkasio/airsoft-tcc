<?php

namespace App\Http\Controllers;

use App\City;
use App\Event;
use App\League;
use App\LeagueProfileInvites;
use App\LeagueTeam;
use App\Post;
use App\Profile;
use App\ProfileLeague;
use App\State;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use LarapexChart;

class LeagueController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    }

    public function dashboard()
    {
        $league = Auth::user()->league;



        //RESUMO GERAL
        //MEMBROS
        $members = ProfileLeague::where('league_id', $league->id)->get();
        $chartData = $this->getMesesFactory($members);

        $chartMembers = LarapexChart::lineChart()
            ->setTitle('Entrada de Membros por mês ' . '(' . Carbon::today()->format('Y') . ')')
            ->setType('bar')
            ->addData('Membros ', $chartData)
            ->setXAxis(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']);

        // TIMES
        $teams = LeagueTeam::where('league_id', $league->id)->get();
        // TOTAL DE JOGOS


        // GRÁFICO EVENTOS CADASTRADOS POR MÊS
        $events = Event::where('league_id', $league->id)->get();
        $chartEvents = $events->groupBy(function ($val) {
            return Carbon::parse($val->startdate)->format('m-Y');
        });

        $eventFinished = $events->filter(function ($val) {
            return $val->status === 'Finalizado';
        })->groupBy(function ($val) {
            return Carbon::parse($val->startdate)->format('m-Y');
        });

        $eventCanceled = $events->filter(function ($val) {
            return $val->status === 'Cancelado';
        })->groupBy(function ($val) {
            return Carbon::parse($val->startdate)->format('m-Y');
        });

        $eventByMonth = [];
        $monthEvent = [];
        foreach ($chartEvents as $data) {
            $eventByMonth[] = count($data);
            $monthsUsers[] = $data[0]->startdate->format('M Y');
        }


        $events = Event::where('league_id', $league->id)->whereYear('created_at', Carbon::today()->format('Y'))->get();
        $eventCreate = $this->getMesesFactory($events);

        $eventCanceled = $this->getMesesFactory($events->filter(function ($value, $key) {
            return $value->status === 'Cancelado';
        }));

        $eventFinish = $this->getMesesFactory($events->filter(function ($value, $key) {
            return $value->status === 'Finalizado';
        }));

        $eventPlanned = $this->getMesesFactory($events->filter(function ($value, $key) {
            return $value->status === 'Planejado';
        }));

        $chartEvents = LarapexChart::barChart()
            ->setTitle('Eventos por Mês ' . '(' . Carbon::today()->format('Y') . ')')
            ->setColors(['#1F487C', '#F79649', '#9BBB58', '#7159c1'])
            ->addData('Iniciados', $eventCreate)
            ->addData('Cancelados', $eventCanceled)
            ->addData('Finalizados', $eventFinish)
            ->addData('Planejados', $eventPlanned)
            ->setXAxis(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']);


        $teamWithEvents = LeagueTeam::where('league_id', $league->id)->whereYear('created_at', Carbon::today()->format('Y'))->with('organizer')->get();


        $teamEvents = [];
        foreach ($teamWithEvents as  $team) {
            $teamEventsData[] = $team->organizer->count();
            $teamEventsName[] = $team->team->name;
        }


        array_unshift($teamEventsData, Event::where('league_id', $league->id)->where('team_id', null)->count());
        array_unshift($teamEventsName, "Administração");


        $eventsByteam = LarapexChart::polarAreaChart()
            ->setTitle('Eventos distribuidos por time ' . '(' . Carbon::today()->format('Y') . ')')
            ->addData($teamEventsData)
            ->setLabels($teamEventsName);


        $postsByMonth = Post::where('league_id', $league->id)->whereYear('created_at', Carbon::today()->format('Y'))->get();
        $postsData = $this->getMesesFactory($postsByMonth);

        $chartPosts = LarapexChart::barChart()
            ->setTitle('Postagens por Mês ' . '(' . Carbon::today()->format('Y') . ')')
            ->setColors(['#1F487C', '#F79649', '#9BBB58', '#7159c1'])
            ->addData('Postagens', $postsData)
            ->setXAxis(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']);

        return view('league.dashboard.index', compact('members', 'teams', 'chartMembers', 'chartEvents', 'eventsByteam', 'chartPosts'));
    }

    private function getMesesFactory($object)
    {
        $array = [];
        for ($i = 1; $i <= 12; $i++) {
            $array[] = $object->filter(function ($value) use ($i) {
                $mes = substr($value->created_at, 5, 2);
                if ($i < 10)
                    return $mes == '0' . $i;
                return $mes == $i;
            })->count();
        }
        return $array;
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
        $states = State::all();
        $cities = City::all();
        return view('league.edit.index', compact('states', 'cities'));
    }

    public function editForm()
    {
        return view('league.posts.edit');
    }

    public function update(Request $request)
    {
        try {
            $data = $request->all();


            $data['state_id'] = $data['estado'];
            $data['city_id'] = $data['cidade'];
            $data['foundation'] = date("Y-m-d", strtotime($data['foundation']));

            $valid =  Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'foundation' => ['required', 'date_format:Y-m-d'],
                "estado" => ['required', 'string'],
                "cidade" => ['required', 'string'],
                "about" => ['required', 'string']
            ]);
            $valid->validate();

            $league = League::find(Auth::user()->league->id);

            $avatar = $this->uploadAvatar($request, $league);

            if ($avatar) {
                $data['avatar'] = $avatar;
            }

            $league->update($data);

            toastr()->success('Liga atualziada');
            return redirect()->route('liga-me');
        } catch (ValidationException $e) {
            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
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
            return null;
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
        $members = ProfileLeague::where('league_id', $league->id)->paginate(10);
        return view('league.members.show', compact('members'));
    }

    public function showMember($id)
    {
        try {
            $league = Auth::user()->league;
            $member = ProfileLeague::findOrFail($id);

            if ($member) {
                return view('league.members.edit.index', compact('member'));
            }
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function updateMember(Request $request, $id)
    {

        $data = $request->all();
        $member = ProfileLeague::find($id);

        $valid = Validator::make($data, [
            'type' => ['required', Rule::in(['Membro', 'Moderador'])],
        ]);

        $valid->validate();

        if ($member) {
            $member->update($data);

            $member->save();

            toastr()->success('Membro atualziado');
            return redirect()->route('liga-membros-all');
        }

        toastr()->error('Ops... algo de errado aconteceu');
        return redirect()->back();
    }

    public function removeMember(Request $request)
    {
        $data = $request->all();
        $profile = Profile::findOrFail($data['profile']);
        $league = Auth::user()->league;

        $isMember = ProfileLeague::where('profile_id', $profile->id)->where('league_id', $league->id)->first();

        if ($isMember) {

            $isMember->delete();
            toastr()->success('Membro Removido da liga');
            return redirect()->back();
        }

        toastr()->error('Ops... algo de errado aconteceu');
        return redirect()->back();
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
