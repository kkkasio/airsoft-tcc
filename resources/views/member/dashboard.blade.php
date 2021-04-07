@extends('member.layouts.base')

@section('title', '- Dashboard')

@section('content')
<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title">
                        Visão Geral
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Armas</h3>
                        <p>Total de armas cadastradas: {{count(Auth::user()->profile->weapons)}}</p>
                        <a href="{{route('membro-me-weapon-all')}}" class="btn btn-sm btn-primary">Minhas Armas</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Liga</h3>
                        @if ($league)
                        <p>{{$league->league->name}} - {{$league->type}}</p>
                        <p>Total de membros: {{count($league->league->members)}}</p>
                        @if($league->type === 'Moderador')
                        <p><strong>Você é moderador da liga</strong>, você pode realizar o login no perfil da liga.
                            <form action="{{route('membro-liga-login')}}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-primary">Entrar no perfil da liga</button>
                            </form>
                        </p>
                        @endif

                        @else
                        <p>Você ainda não participa de uma liga.</p>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Eventos</h3>
                        @if($league->league)
                        <p>Eventos da liga {{count($league->league->events)}}</p>
                        <p>Eventos que participei: {{count($events)}}</p>
                        <a href="{{route('membro-league-show-events')}}" class="btn btn-sm btn-primary">Visualizar
                            Eventos</a>
                        @else
                        <p>Você ainda não participa de uma liga.</p>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>


@endsection
