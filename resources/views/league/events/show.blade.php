@extends('league.layouts.base')

@section('title', '- Visualizar Evento')

@section('content')

<style>
    .whole-page-overlay {
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        position: fixed;
        background: rgba(0, 0, 0, 0.6);
        width: 100%;
        height: 100% !important;
        z-index: 1050;
        display: none;
        backdrop-filter: blur(4px);
    }

    .whole-page-overlay .center-loader {
        top: 50%;
        left: 52%;
        position: absolute;
        color: white;
    }
</style>
<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        {{$event->name}} - {{$event->startdate->format('d/m/Y')}} ({{$event->status}})
                    </h2>
                </div>
                @can('manage-event', $event)




                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                        @if($event->status === 'Planejado')
                        <form action="{{ route('league-event-open',['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event" value="{{$event->id}}">
                            <button type="submit" class="btn btn-primary d-sm-inline-block">
                                Abrir Inscrições
                            </button>
                        </form>
                        @endif

                        @if($event->status === 'Aberto')
                        <form action="{{ route('league-event-close',['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event" value="{{$event->id}}">
                            <button type="submit" class="btn btn-primary d-sm-inline-block">
                                Encerrar Inscrições
                            </button>
                        </form>
                        @endif

                        @if($event->status === 'Inscrições Encerradas')
                        <form action="{{ route('league-event-finish',['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event" value="{{$event->id}}">
                            <button type="submit" class="btn btn-primary d-sm-inline-block">
                                Finalizar Evento
                            </button>
                        </form>
                        @endif



                    </div>
                </div>
                @endcan

            </div>
        </div>


        <div class="row row-cards  my-3">
            <div class="col-md-4 col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Informações</div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="13" r="7"></circle>
                                <polyline points="12 10 12 13 14 13"></polyline>
                                <line x1="7" y1="4" x2="4.25" y2="6"></line>
                                <line x1="17" y1="4" x2="19.75" y2="6"></line>
                            </svg>
                            Início: <strong>{{$event->startdate->format('d/m/Y H:m')}}</strong>
                        </div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="13" r="7"></circle>
                                <polyline points="12 10 12 13 14 13"></polyline>
                                <line x1="7" y1="4" x2="4.25" y2="6"></line>
                                <line x1="17" y1="4" x2="19.75" y2="6"></line>
                            </svg>
                            Término: <strong>{{$event->enddate->format('d/m/Y H:m')}}</strong>
                        </div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                <line x1="9" y1="9" x2="10" y2="9"></line>
                                <line x1="9" y1="13" x2="15" y2="13"></line>
                                <line x1="9" y1="17" x2="15" y2="17"></line>
                            </svg>
                            Missão: <strong>@if($event->file) <a href="{{Storage::url('/files/'.$event->file)}}"
                                    target="_blank">Clique Aqui</a> @else Não Enviado @endif </strong>
                        </div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="11" r="3"></circle>
                                <path
                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                                </path>
                            </svg>
                            Local: <strong>{{$event->location ? $event->location: 'Não informado'}}</strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="11" r="3"></circle>
                                <path
                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                                </path>
                            </svg>
                            Organização: <strong>{{$event->team ? $event->team->name : 'Administração'}}</strong>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                            </svg>
                            Minimo de Jogadores: <strong>{{$event->players}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-6 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Sobre o evento</div>
                        <div class="mb-2">
                            {{$event->about}}
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="col-12">
            <div class="card">

                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-muted">
                            <strong>Inscritos ({{count($event->subscribers)}})</strong>
                        </div>
                        <input id="event-id" type="hidden" name="event" value="{{$event->id}}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">Inscrição</th>
                                <th>Nome</th>
                                <th>Time</th>
                                <th>Data</th>
                                <th>SQUAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscribers as $subscriber)

                            <tr>
                                <td><span class="text-muted">#{{$subscriber->id}}</span></td>
                                <td><a href="{{route('liga-membro-show',['id' => $subscriber->profile->id])}}"
                                        class="text-reset" tabindex="-1">{{$subscriber->profile->name}}</a></td>
                                <td>
                                    {{$subscriber->profile->team ? $subscriber->profile->team->team->name : '' }}
                                </td>


                                <td>
                                    {{$subscriber->created_at->format('d/m/Y')}}
                                </td>


                                <td>
                                    <select name="squad" class="form-select"
                                        data-profile-id="{{$subscriber->profile->id}}">
                                        <option value="0">Selecione o SQUAD</option>
                                        @foreach ($squads as $squad)
                                        <option value="{{$squad->id}}"
                                            {{$subscriber->squad_id === $squad->id ? 'selected': '' }}>{{$squad->name}}
                                        </option>
                                        @endforeach

                                    </select>
                                </td>


                            </tr>

                            @empty
                            <td colspan="4">Nada encontrado</tr>
                                @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">Exibindo <span>{{$subscribers->count()}}</span> de
                        {{$subscribers->total()}}
                        em <span>{{$subscribers->lastPage()}}</span> páginas</p>
                    <ul class="pagination m-0 ms-auto">

                        {{$subscribers->render()}}

                    </ul>
                </div>
            </div>
        </div>



        <div class="row mt-5">
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                        </div>
                        <h2 class="page-title">
                            Squads ({{count($squads)}})
                        </h2>
                    </div>
                    @if($event->status == 'Aberto' && $event->team === null && $event->league_id ===
                    Auth::user()->league->id)
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <span class="d-sm-inline-block">
                                <a href="#" class="btn btn-white" data-bs-toggle="modal"
                                    data-bs-target="#modal-new-squad">
                                    Criar novo Squad
                                </a>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>


            @forelse ($squads as $squad)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title"><b>SQUAD:</b> {{$squad->name}} ({{count($squad->squadMembers)}})</h3>
                    </div>
                    <div id="{{$squad->name}}" data-squad-id="{{$squad->id}}" class="connected-sortable py-4">
                        @foreach($squad->squadMembers as $key => $value)
                        <li class="list-group-item cursor-move" profile-id="{{$value->profile->id}}">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="#">
                                        <span class="avatar"
                                            style="background-image: url(./static/avatars/002f.jpg)"></span>
                                    </a>
                                </div>
                                <div class="col text-truncate">
                                    <span class="text-body d-block">{{ $value->profile->name }}</span>
                                    <small
                                        class="d-block text-muted text-truncate mt-n1">{{$value->profile->team ? $value->profile->team->team->name : 'Sem time'}}</small>
                                </div>

                            </div>
                        </li>

                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <h2>Ainda não foi criado nenhum squad.</h2>
            @endforelse
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-new-squad" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form id="form-create-squad" action="{{ route('liga-evento-squad-create') }}" method="POST"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Novo Squad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="BDU / PMC">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <input type="hidden" name="event_id" value="{{$event->id}}">
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
                        Criar Squad
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="whole-page-overlay" id="whole_page_loader">
        <div class="spinner-border center-loader" role="status"></div>

    </div>
    <div>
        <form method="POST" id="form-TESTE" action="{{ route('liga-evento-squad-update') }}">
            @csrf
            <input id="squad" type="hidden" name="squad" value="">
            <input id="profile" type="hidden" name="profile" value="">
            <input id="event" type="hidden" name="event" value="">
        </form>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $('select').on('change', function() {
        $('#whole_page_loader').css('display','block');
        var squad = $('#squad').val($("option:selected", this).val());
        var profile = $('#profile').val($(this).attr('data-profile-id'));
        var event = $('#event').val($('#event-id').val());

        $('#form-TESTE').submit();
    });


    $('#sendForm').on('click', function(){
        $('#form-create-squad').submit();
    })
</script>
@endsection
