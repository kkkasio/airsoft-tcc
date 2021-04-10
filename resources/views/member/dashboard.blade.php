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
                        @if($league)
                        <p>Eventos da liga {{count($league->league->events)}}</p>
                        <p>Eventos que participei: {{count($events)}}</p>
                        <a href="{{route('membro-league-show-events')}}" class="btn btn-sm btn-primary">Visualizar
                            Eventos</a>
                        @else
                        <p>Você ainda não participa de uma liga.</p>
                        <button class="btn btn-dark my-2" data-bs-toggle="modal" data-bs-target="#modal-league-form">Tem
                            um código de convite?</button>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>

@if (!$league)

<div class="modal modal-blur fade" id="modal-league-form" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form id="form-invite" action="{{ route('membro-league-invite') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Convite para liga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Código</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                        placeholder="Informe o código" required>
                    @error('code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button id="sendFormInvite" type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                    Enviar
                </button>

            </div>
        </form>
    </div>
</div>

<script>
    $("#sendFormWeapon").click(function(){
        $("#form-weapon").submit();
    })

    $("#sendFormInvite").click(function(){
        $("#form-invite").submit();
    })

</script>

@endif


@endsection
