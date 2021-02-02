@extends('member.layouts.base')

@section('title', '- Time '. $team->name)

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title">
                        {{$team->name}}
                    </div>
                </div>
                @if(Auth::user()->profile->myTeam->first()->id === $team->id && Auth::user()->profile->myTeam->first()->pivot->type === 'Moderador')
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            <a href="{{route('membro-time-edit-form',['slug' => $team->slug])}}" class="btn btn-white">
                                Editar Time
                            </a>
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </div>


        <div class="row row-cards">
            <div class="col-md-4 col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Informações</div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                            </svg>
                            URL: <strong><?php echo config('app.url')."/time/{$team->slug}" ?></strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                <line x1="16" y1="3" x2="16" y2="7"></line>
                                <line x1="8" y1="3" x2="8" y2="7"></line>
                                <line x1="4" y1="11" x2="20" y2="11"></line>
                                <line x1="11" y1="15" x2="12" y2="15"></line>
                                <line x1="12" y1="15" x2="12" y2="18"></line>
                            </svg>
                            Data de Fundação: <strong>14/08/1993</strong>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <polyline points="12 7 12 12 15 15"></polyline>
                            </svg>
                            Sobre: <strong>{{$team->about}}</strong>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Informações</div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                            </svg>
                            URL: <strong><?php echo config('app.url')."/time/{$team->slug}" ?></strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                <line x1="16" y1="3" x2="16" y2="7"></line>
                                <line x1="8" y1="3" x2="8" y2="7"></line>
                                <line x1="4" y1="11" x2="20" y2="11"></line>
                                <line x1="11" y1="15" x2="12" y2="15"></line>
                                <line x1="12" y1="15" x2="12" y2="18"></line>
                            </svg>
                            Data de Fundação: <strong>14/08/1993</strong>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <polyline points="12 7 12 12 15 15"></polyline>
                            </svg>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-title mt-3 mb-2">
            Membros ({{count($team->members)}})
        </div>
        <div class="row row-cards">
            @foreach ($team->members as $member)

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url(./static/avatars/000m.jpg)">{{$member->initials}}</span>
                        <h3 class="m-0 mb-1">{{$member->name}}</h3>

                        <div class="text-muted">
                            @if($member->pivot->type === 'Moderador')
                            <span class="badge bg-purple-lt">
                                {{$member->pivot->type}}
                            </span>
                            @else
                            <span class="badge bg-green-lt">
                                {{$member->pivot->type}}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
