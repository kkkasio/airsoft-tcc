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
                @if(Auth::user()->profile->team && Auth::user()->profile->team->team->id === $team->id &&
                Auth::user()->profile->team->type === 'Moderador' )
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-at" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28"></path>
                            </svg>
                            Nome: <strong>{{$team->name}}</strong>
                        </div>

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
                        <div class="card-title">Liga</div>
                        @if($team->league)
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                            </svg>
                            Liga: <strong>{{$team->league->league->name}}</strong>
                        </div>
                        @else
                        <p>O time ainda não participa de uma liga</p>
                        @if(Auth::user()->profile->team->team->slug === $team->slug && Auth::user()->profile->team->type
                        === 'Moderador')
                        <div class="mt-2">
                            <a href="#" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#modal-report">
                                Tenho um código de convite
                            </a>
                        </div>
                        @endif

                        @endif

                    </div>
                </div>
            </div>

            @if(Auth::user()->profile->team->team->slug === $team->slug && Auth::user()->profile->team->type
            === 'Moderador')
            <div class="col-md-4 col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Convidar Membro</div>

                        <p>Códigos disponíveis:
                            {{count(Auth::user()->profile->team->team->invites()->where('used',null)->get())}}</p>
                        @if(Auth::user()->profile->team->team->slug === $team->slug && Auth::user()->profile->team->type
                        === 'Moderador')
                        <div class="mt-2">
                            <a href="{{route('membro-time-show-invites',['slug' => Auth::user()->profile->team->team->slug ])}}"
                                class="btn btn-white">
                                Ver Códigos
                            </a>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            @endif
        </div>


        <div class="mt-4 page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title">
                        Membros ({{count($team->members)}})
                    </div>
                </div>
                @if(Auth::user()->profile->team && Auth::user()->profile->team->team->id === $team->id &&
                Auth::user()->profile->team->type === 'Moderador' )
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            <a href="{{route('membro-time-members-export')}}" class="btn btn-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                    </path>
                                    <line x1="9" y1="9" x2="10" y2="9"></line>
                                    <line x1="9" y1="13" x2="15" y2="13"></line>
                                    <line x1="9" y1="17" x2="15" y2="17"></line>
                                </svg>
                                Exportar
                            </a>
                        </span>
                    </div>
                </div>
                @endif

            </div>
        </div>

        <div class="row row-cards">
            @foreach ($team->members as $member)

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url(./static/avatars/000m.jpg)">{{$member->profile->initials}}</span>
                        <h3 class="m-0 mb-1">{{$member->profile->name}}</h3>

                        <div class="text-muted">
                            @if($member->type === 'Moderador')
                            <span class="badge bg-purple-lt">
                                {{$member->type}}
                            </span>
                            @else
                            <span class="badge bg-green-lt">
                                {{$member->type}}
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


<div class="modal modal-blur fade" id="modal-report" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form id="form" action="{{ route('membro-time-invite-post',['slug'=>$team->slug]) }}" method="POST"
            class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Ingressa em uma liga por código de convite</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Código</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                        placeholder="Digite o código">
                </div>
                @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button id="sendForm" type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $("button[type=submit").click(function(){
        $("form").submit();
    })
</script>


@endsection
