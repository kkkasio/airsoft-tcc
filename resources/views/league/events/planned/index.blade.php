@extends('league.layouts.base')

@section('title', '- Eventos Planejados')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Eventos Planejados ({{count($planned)}})
                    </h2>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            @forelse ($planned as $event)
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-img-top img-responsive img-responsive-16by9"
                        style="background-image: url(https://baladasegura.rs.gov.br/themes/modelo-institucional/images/outros/GD_imgSemImagem.png)">
                    </div>

                    <div class="card-body p-4 text-center">

                        <h3 class="m-0 mb-1"><a
                                href="{{ route('membro-league-show-event',['id' => $event->id])}}">{{$event->name}}</a>
                        </h3>
                        <div class="text-muted">Data: {{$event->startdate->format('d/m/Y')}}</div>
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
                        <a href="{{ route('liga-evento-show',['id' => $event->id])}}" class="card-btn"><svg
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
