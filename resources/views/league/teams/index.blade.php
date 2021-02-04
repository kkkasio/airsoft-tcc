@extends('league.layouts.base')

@section('title', '- Times')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Times da liga ({{count($league->teams)}})
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            <a href="#" class="btn btn-white">
                                Editar Times
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            @forelse ($league->teams as $team)

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url(./static/avatars/000m.jpg)">{{$team->initials}}</span>
                        <h3 class="m-0 mb-1">{{{$team->name}}}</h3>

                        <div class="text-muted">
                            <p>rsrs</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p>Nenhum time encontrado</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
