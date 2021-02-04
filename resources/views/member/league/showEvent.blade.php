@extends('member.layouts.base')

@section('title', '- Evento '. $event->name)

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        {{$event->name}} - {{$event->date->format('d/m/Y')}} ({{$event->status}})
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            @if($event->status === 'Aberto')
                            <a href="{{ route('membro-me-edit-form') }}" class="btn btn-white">
                                Participar
                            </a>
                            @endif
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
                            <b>Data:</b> {{$event->date->format('d/m/Y')}}
                        </div>
                        <div class="mb-1">
                            <b>Mínimo de inscritos:</b> {{$event->players}}
                        </div>
                        <div class="mb-1">
                            <b>Total de Inscritos:</b> 0
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

        <div class="page-header d-print-none mt-3">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Inscritos (0)
                    </h2>
                </div>


        </div>
    </div>
</div> @endsection
