@extends('member.layouts.base')

@section('title', '- Eventos Liga')

@section('content')

<div class="content">
    <div class="container-xl">
        <h2 class="page-title my-3">
            Eventos da Liga: {{Auth::user()->profile->league->league->name}}
        </h2>

        <div class="row row-cards">
            @forelse ($events as $event)
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-img-top img-responsive img-responsive-16by9"
                        style="background-image: url(https://baladasegura.rs.gov.br/themes/modelo-institucional/images/outros/GD_imgSemImagem.png)">
                    </div>

                    <div class="card-body p-4 text-center">

                        <h3 class="m-0 mb-1"><a
                                href="{{ route('membro-league-show-event',['id' => $event->id])}}">{{$event->name}}</a>
                        </h3>
                        <div class="text-muted">Data: {{$event->date->format('d/m/Y')}}</div>
                        <div class="mb-3">
                            <span><b>Situação:</b> {{$event->status}}</span>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-green-lt">Organização:
                                {{$event->team ? $event->team->name : 'Administração' }}</span>
                        </div>
                        @if($event->type === 'Jogo')
                        <div class="mt-3">
                            <div class="text-muted">
                                <b>Inscritos:</b> 0
                            </div>
                            <div class="text-muted">
                                <b>Quórum mínimo:</b> {{$event->players}}
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="d-flex">
                        <a href="{{ route('membro-league-show-event',['id' => $event->id])}}" class="card-btn"><svg
                                xmlns="http://www.w3.org/2000/svg" class="icon mx-1 icon-tabler icon-tabler-list-search"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="15" cy="15" r="4"></circle>
                                <path d="M18.5 18.5l2.5 2.5"></path>
                                <path d="M4 6h16"></path>
                                <path d="M4 12h4"></path>
                                <path d="M4 18h4"></path>
                            </svg>
                            Visualizar</a>
                        <a href="#" id="btnRemove" data-weapon="4" data-bs-toggle="modal" data-bs-target="#modal-remove"
                            class="card-btn">

                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mx-1 icon-tabler icon-tabler-checks"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 12l5 5l10 -10"></path>
                                <path d="M2 12l5 5m5 -5l5 -5"></path>
                            </svg>
                            Participar</a>
                    </div>
                </div>
            </div>
            @empty
            <p>Nenhum evento cadastrado</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
