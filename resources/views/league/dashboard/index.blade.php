@extends('league.layouts.base')

@section('title', '- Dashboard')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Visão Geral ({{\Carbon\Carbon::today()->format('Y')}})
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-status-start bg-primary"></div>
                    <div class="card-body">
                        <h3 class="card-title">Card with side status</h3>
                        <p><strong>Total de Membros</strong>: {{count($members)}}</p>
                        <p><strong>Total de Times</strong>: {{count($teams)}}</p>
                        <p><strong>Total de Eventos</strong>: {{count($members)}}</p>
                    </div>
                </div>
            </div>

            <div class="row ">
                <div class=" my-3 col-sm-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            {!! $chartMembers->container() !!}
                        </div>
                    </div>

                </div>
                <div class=" my-3 col-sm-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            {!! $chartEvents->container() !!}
                        </div>
                    </div>
                </div>

                <div class=" my-3 col-sm-6 col-lg-6 my-3">
                    <div class="card">
                        <div class="card-body">
                            {!! $eventsByteam->container() !!}
                        </div>
                    </div>
                </div>

                <div class="my-3 col-sm-6 col-lg-6 my-3">
                    <div class="card">
                        <div class="card-body">
                            {!! $chartPosts->container() !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="my-3 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {!! $chartUsersCity->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="{{ LarapexChart::cdn() }}"></script>
{{ $chartMembers->script() }}
{{ $chartEvents->script() }}
{{ $eventsByteam->script() }}
{{ $chartPosts->script()  }}
{{ $chartUsersCity->script() }}

@endsection
