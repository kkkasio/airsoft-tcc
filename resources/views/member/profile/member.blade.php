@extends('member.layouts.base')

@section('title', '- Perfil de ' . $member->name)

@section('content')


<div class="content">
    <div class="container-xl">

        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Perfil de {{$member->name}}
                    </h2>
                </div>


            </div>
        </div>
        <div class="row row-cards">
            <div class="col-md-6 col-sm-12 col-lg-4">
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
                            Nome: <strong>{{$member->name}}</strong>
                        </div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-at" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28"></path>
                            </svg>
                            Apelido: <strong>{{$member->nickname}}</strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            </svg>
                            Gênero: <strong>{{$member->gender === 'F' ? 'Feminino': 'Masculino'}}</strong>
                        </div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-unlink"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5"></path>
                                <path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5"></path>
                                <line x1="16" y1="21" x2="16" y2="19"></line>
                                <line x1="19" y1="16" x2="21" y2="16"></line>
                                <line x1="3" y1="8" x2="5" y2="8"></line>
                                <line x1="8" y1="3" x2="8" y2="5"></line>
                            </svg>
                            URL: <strong><?php echo config('app.url')."/membro/{$member->slug}" ?></strong>
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
                            Data de Nascimento: <strong>{{ date('d/m/Y', strtotime($member->birthday)) }}</strong>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="11" r="3"></circle>
                                <path
                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                                </path>
                            </svg>
                            Localização: <strong>{{ $member->state->letter}}</strong> -
                            <strong>{{ $member->city->title }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Time</div>
                        @if($team = $member->team)
                        <div class="mb-2">
                            Nome: <strong>{{$team->team->name}}</strong>
                        </div>
                        <div class="mb-2">
                            Total de membros: <strong>{{count($team->team->members)}}</strong>
                        </div>
                        @else
                        <div class="mb-2">
                            Ops... Membro ainda não participa de um time.
                        </div>

                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Liga</div>
                        @if($member->league)
                        <div class="mb-2">
                            Nome: <strong>{{$member->league->league->name}}</strong>
                        </div>
                        <div class="mb-2">
                            Total de membros: <strong>{{count($member->league->league->members)}}</strong>
                        </div>
                        @else
                        <div class="mb-2">
                            Ops... Membro ainda não participa de uma liga.

                        </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="page-header d-print-none mt-5">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Armas ({{count($member->weapons)}})
                    </h2>
                </div>
            </div>
        </div>

        <div class="row row-cards">

            @forelse($member->weapons as $weapon)
            <div class="col-md-4">
                <div class="card card-stacked">
                    <div class="card-header">
                        <div class="card-title">
                            {{$weapon->name}} - {{$weapon->type}}

                            <div class="mb-2">
                                @if($weapon->nickname)
                                <small>Conhecida como: {{$weapon->nickname}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p>Nenhuma arma cadastrada</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
