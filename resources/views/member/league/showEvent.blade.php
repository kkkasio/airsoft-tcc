@extends('member.layouts.base')

@section('title', '- Evento '. $event->name)

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<style>
    div.stars {
        width: 270px;
        display: inline-block;
    }

    input.star {
        display: none;
    }

    label.star {
        float: right;
        padding: 10px;
        font-size: 36px;
        color: #444;
        transition: all .2s;
    }

    input.star:checked~label.star:before {
        content: '\f005';
        color: #FD4;
        transition: all .25s;
    }

    input.star-5:checked~label.star:before {
        color: #FE7;
        text-shadow: 0 0 20px rgba(153, 85, 34, 0.12);
    }

    input.star-1:checked~label.star:before {
        color: #F62;
    }

    label.star:hover {
        color: #FE7;
        transform: rotate(-15deg) scale(1.3);
    }

    input .star:before {
        color: #fe7;
    }

    label.star:before {
        content: '\f006';
        font-family: FontAwesome;
    }
</style>

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{$event->name}} - {{$event->startdate->format('d/m/Y')}} ({{$event->status}})
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                        @can('manage-event', $event)

                        @if($event->status === 'Planejado')
                        <form action="{{ route('membro-event-open',['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event" value="{{$event->id}}">
                            <button type="submit" class="btn btn-primary d-sm-inline-block">
                                Abrir Inscrições
                            </button>
                        </form>
                        @endif
                        @if($event->status === 'Aberto')
                        <form action="{{ route('membro-event-close',['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event" value="{{$event->id}}">
                            <button type="submit" class="btn btn-primary d-sm-inline-block">
                                Encerrar Inscrições
                            </button>
                        </form>
                        @endif

                        @if($event->status === 'Inscrições Encerradas')
                        <form action="{{ route('membro-event-finish',['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event" value="{{$event->id}}">
                            <button type="submit" class="btn btn-primary d-sm-inline-block">
                                Finalizar Evento
                            </button>
                        </form>
                        @endif
                        @endif

                        <span class="d-sm-inline-block">
                            @if($event->status === 'Aberto')
                            @if(!$participacao)
                            <form action="{{ route('membro-event-subscribe',['id' => $event->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="event" value="{{$event->id}}">
                                <button type="submit" class="btn btn-white">
                                    Participar
                                </button>
                            </form>

                            @else
                            <form action="{{route('membro-event-unsubscribe',['id' => $event->id])}}" method="POST">
                                @csrf
                                <input type="hidden" name="event" value="{{$event->id}}">
                                <button type="submit" class="btn btn-white">
                                    Cancelar Participação
                                </button>
                            </form>
                            @endif
                            @endcan
                        </span>
                    </div>
                </div>
            </div>
        </div>



        <div class="row row-cards">
            <div class="col-lg-8">
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="markdown">
                            <p>
                                {{$event->about}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h2>Sobre o evento</h2>
                        <div class="mb-1">
                            <b>Organização:</b> {{$event->team ? $event->team->name : 'Administração'}}
                        </div>
                        <div class="mb-1">
                            <b>Data e hora de início:</b> {{$event->startdate->format('d/m/Y H:m')}}
                        </div>
                        <div class="mb-1">
                            <b>Data e hora de término:</b> {{$event->enddate->format('d/m/Y H:m')}}
                        </div>
                        <div class="mb-1">
                            <b>Mínimo de inscritos:</b> {{$event->players}}
                        </div>
                        <div class="mb-1">
                            <b>Total de Inscritos:</b> {{count($event->subscribers)}}
                        </div>
                        @if($event->file)
                        <div class="mb-1">
                            <b>Arquivo do Jogo</b>: {{$event->file}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
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

                                <form action="" method="POST">
                                    @csrf
                                    <td>
                                        {{$subscriber->created_at->format('d/m/Y')}}
                                    </td>
                                </form>

                                <td>
                                    @if($event->status == 'Aberto' && $event->team && Auth::user()->profile->team &&
                                    $event->team->id ===
                                    Auth::user()->profile->team->team->id && Auth::user()->profile->team->type ===
                                    'Moderador')
                                    <select name="squad" class="form-select"
                                        data-profile-id="{{$subscriber->profile->id}}">
                                        <option value="0">Selecione o SQUAD</option>
                                        @foreach ($squads as $squad)
                                        <option value="{{$squad->id}}"
                                            {{$subscriber->squad_id === $squad->id ? 'selected': '' }}>{{$squad->name}}
                                        </option>
                                        @endforeach

                                    </select>
                                    @else
                                    {{$subscriber->squad ? $subscriber->squad->name : '-' }}
                                    @endif
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

        @if ($event->status === 'Finalizado' && \Carbon\Carbon::now()::now()->diffInHours($event->enddate) > 2)
        <div class="row row-cards mt-4">
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">Avaliações & Comentários</h2>
                    </div>
                    @can('can-comment', $event)
                    <div class="col-auto ms-auto d-print-none">
                        <a href="#" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#modal-comment">
                            Escrever um comentário
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-body">
                    <div class="divide y-4">
                        @forelse ($event->ratings as $comment)
                        <div class="row">
                            <div class="col-auto">
                                <span class="avatar">{{$comment->profile->initials}}</span>
                            </div>
                            <div class="col">
                                <div class="text-truncate">
                                    <strong>
                                        @for ($i = 0; $i < $comment->evaluation; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-filled text-yellow icon-tabler-star" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                                                </path>
                                            </svg>

                                            @endfor
                                    </strong> - {{$comment->comment}}
                                </div>
                                <div class="text-muted">{{$comment->created_at->format('d/m/Y H:m')}}</div>
                            </div>
                        </div>
                        @empty
                        <p class="mt-3">Ainda não temos nenhuma avaliação</p>
                        @endforelse
                    </div>
                </div>
            </div>




        </div>

        @endif

        <div class="row mt-4">
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Squads ({{count($squads)}})
                        </h2>
                    </div>

                    <div class="col-auto ms-auto">
                        @if($event->team && Auth::user()->profile->team &&
                        $event->team->id ===
                        Auth::user()->profile->team->team->id && Auth::user()->profile->team->type ===
                        'Moderador')
                        <form action="{{ route('membro-event-open',['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event" value="{{$event->id}}">
                            <button type="submit" class="btn btn-success d-sm-inline-block">
                                ** EXPORTAR **
                            </button>
                        </form>
                        @endif
                    </div>

                    @if($event->team_id && $event->status === 'Aberto' && Auth::user()->profile->team &&
                    Auth::user()->profile->team->type ===
                    'Moderador' && $event->team_id === Auth::user()->profile->team->team->id )
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
                        <h3 class="card-title"><b>SQUAD:</b> {{$squad->name}} ({{count($squad->squadMembers)}})
                        </h3>
                        
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
</div>

<div class="modal modal-blur fade" id="modal-comment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="formComment" action="{{ route('membro-league-event-comment',['id' => $event->id])}}" method="POST"
            class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Avaliar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Avaliação do Evento</label>
                    <div class="row g-2">
                        <div class="col-auto">
                            <input class="star star-5" id="star-5" type="radio" value="5" name="star" />
                            <label class="star star-5" for="star-5"></label>
                            <input class="star star-4" id="star-4" type="radio" value="4" name="star" />
                            <label class="star star-4" for="star-4"></label>
                            <input class="star star-3" id="star-3" type="radio" value="3" name="star" />
                            <label class="star star-3" for="star-3"></label>
                            <input class="star star-2" id="star-2" type="radio" value="2" name="star" />
                            <label class="star star-2" for="star-2"></label>
                            <input class="star star-1" id="star-1" type="radio" value="1" name="star" />
                            <label class="star star-1" for="star-1"></label>

                        </div>
                        @error('star')
                        <h5 class="text-muted" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </h5>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="comment" class="form-label">Comentário</label>
                    <textarea id="comment" name="comment" placeholder="Escreva um texto curto"
                        class="form-control  @error('comment') is-invalid @enderror"
                        required>{{old('comment')}}</textarea>
                    @error('comment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Fechar</button>
                <button id="sendFormComment" type="button" class="btn btn-primary"
                    data-bs-dismiss="modal">Enviar</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#sendFormComment').on('click', function(){
        $('#formComment').submit();
    })
</script>

@if($event->status == 'Aberto' && $event->team && Auth::user()->profile->team && $event->team->id ===
Auth::user()->profile->team->team->id && Auth::user()->profile->team->type === 'Moderador')


<div class="modal modal-blur fade" id="modal-new-squad" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form id="form-create-squad" action="{{ route('membro-evento-squad-create',['id'=> $event->id]) }}"
            method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Novo Squad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                        placeholder="BDU / PMC">
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
    <form method="POST" id="form-squad" action="{{ route('membro-evento-squad-update') }}">
        @csrf
        <input id="squad" type="hidden" name="squad" value="">
        <input id="profile" type="hidden" name="profile" value="">
        <input id="event" type="hidden" name="event" value="">
    </form>
</div>



@include('member.league._script')
@endif
@endsection
