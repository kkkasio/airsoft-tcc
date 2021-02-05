@extends('league.layouts.base')

@section('title', '- Eventos')

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
                        Evento: {{$event->name}}
                    </h2>
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
                        <div class="ms-auto text-muted">
                            Pesquisar:
                            <div class="ms-2 d-inline-block">
                                <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                            </div>
                        </div>
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
                                <td><span class="text-muted">001401</span></td>
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
                                    <select name="squad" class="form-select"
                                        data-profile-id="{{$subscriber->profile->id}}">
                                        <option value="0">Selecione o SQUAD</option>
                                        @foreach ($squads as $squad)
                                        <option value="{{$squad->id}}" {{$subscriber->squad_id === $squad->id ? 'selected': '' }}>{{$squad->name}}</option>
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
            <h2 class="text-center pb-3 pt-1">Squads</h2>
            @foreach ($squads as $squad)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title"><b>SQUAD:</b> {{$squad->name}}</h3>
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
            @endforeach
        </div>
        @csrf
    </div>

    <div class="whole-page-overlay" id="whole_page_loader">
        <div class="spinner-border center-loader" role="status"></div>

    </div>
    <div>
        <form method="POST" id="form-squad" action="{{ route('liga-evento-squad-update') }}">
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
        var event = $('#event').val($('#event-id').val())

        $('#form-squad').submit();

    });


</script>
@endsection
