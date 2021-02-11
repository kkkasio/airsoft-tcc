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
            </div>
        </div>

        <div class="row row-cards">
            @forelse ($league->teams as $team)
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url(./static/avatars/000m.jpg)">{{$team->team->initials}}</span>
                        <h3 class="m-0 mb-1">{{{$team->team->name}}}</h3>

                        <div class="text-muted">
                            <p>{{$team->team->about}}</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('liga-times-show-members',['slug' => $team->team->slug]) }}" class="card-btn"> <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                            </svg> Ver Membros</a>

                        <a href="#" class="card-btn"> <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-eraser" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M19 19h-11l-4 -4a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9 9">
                                </path>
                                <line x1="18" y1="12.3" x2="11.7" y2="6"></line>
                            </svg> Remover Time</a>
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
