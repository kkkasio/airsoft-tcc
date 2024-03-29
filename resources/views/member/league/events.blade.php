@extends('member.layouts.base')

@section('title', '- Eventos Liga')

@section('content')

<div class="content">
    <div class="container-xl">
        <h2 class="page-title my-3">
            Proximos eventos eventos da Liga
        </h2>

        <div class="row row-cards">
            @forelse ($events as $i => $event)
            <div class="col-md-6 col-lg-3">
                <div class="card">


                    <div class="card-img-top img-responsive img-responsive-16by9"
                        style="background-image: url({{$event->avatar ? '/storage/avatars/'.$event->avatar : 'https://baladasegura.rs.gov.br/themes/modelo-institucional/images/outros/GD_imgSemImagem.png'}})">
                    </div>

                    <div class="card-body p-4 text-center">
                        @if($loop->first)
                        <div class="ribbon ribbon-bookmark" title="Próximo evento">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                                </path>
                            </svg>
                        </div>
                        @endif

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
                        @can('manage-event',$event)
                        <a href="{{ route('membro-league-edit-event',['id' => $event->id])}}" class="card-btn"><svg
                                xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                <line x1="16" y1="5" x2="19" y2="8"></line>
                            </svg>
                            Editar</a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p>Nenhum evento cadastrado</p>
            @endforelse
        </div>

        <div class="mt-4 page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Eventos Encerrados e Finalizados
                    </h2>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Data</th>
                                    <th>Situação</th>
                                    <th>Organização</th>
                                    <th>Quorum mínimo / Inscritos</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($closedEvents as $item)

                                <tr>
                                    <td><a
                                            href="{{ route('membro-league-show-event',['id' => $item->id])}}">{{$item->name}}</a>
                                    </td>
                                    <td class="text-muted">
                                        {{$item->startdate->format('d/m/y')}}
                                    </td>
                                    <td class="text-muted">{{$item->status}}</td>
                                    <td class="text-muted">
                                        {{$item->team ? $item->team->name : 'Administração'}}
                                    </td>
                                    <td>
                                        {{$item->players}} / {{count($item->subscribers)}}
                                    </td>
                                    </td>
                                </tr>

                                @empty
                                <td>Nada cadastrado</td>

                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
