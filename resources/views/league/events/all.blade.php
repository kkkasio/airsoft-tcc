@extends('league.layouts.base')

@section('title', '- Eventos')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Eventos Abertos
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('liga-eventos-aberto') }}" class="btn btn-white">
                            Ver todos os abertos
                        </a>
                    </div>
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
                                    <th>Data e Hora de Início</th>
                                    <th>Situação</th>
                                    <th>Organização</th>
                                    <th>Quorum mínimo / Inscritos</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($open as $item)

                                <tr>
                                    <td><a href="{{ route('liga-evento-show',['id' => $item->id])}}">{{$item->name}}</a></td>
                                    <td class="text-muted">
                                        {{$item->startdate->format('d/m/y H:i')}}
                                    </td>
                                    <td class="text-muted">{{$item->status}}</td>
                                    <td class="text-muted">
                                        {{$item->team ? $item->team->name : 'Administração'}}
                                    </td>
                                    <td>
                                        {{$item->players}} / {{count($item->subscribers)}}
                                    </td>
                                    <td><a href="{{ route('liga-evento-edit-form',['id' => $item->id])}}">Editar</a></td>
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

        <div class="mt-4 page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Eventos Planejados
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('liga-eventos-planejados') }}" class="btn btn-white">
                            Ver todos os planejados
                        </a>
                    </div>
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
                                    <th>Data e Hora de Início</th>
                                    <th>Situação</th>
                                    <th>Organização</th>
                                    <th>Quorum mínimo / Inscritos</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($planned as $item)

                                <tr>
                                    <td><a href="{{ route('liga-evento-show',['id' => $item->id])}}">{{$item->name}}</a></td>
                                    <td class="text-muted">
                                        {{$item->startdate->format('d/m/y H:i')}}
                                    </td>
                                    <td class="text-muted">{{$item->status}}</td>
                                    <td class="text-muted">
                                        {{$item->team ? $item->team->name : 'Administração'}}
                                    </td>
                                    <td>
                                        {{$item->players}} / {{count($item->subscribers)}}
                                    </td>
                                    <td><a href="{{ route('liga-evento-edit-form',['id' => $item->id])}}">Editar</a></td>
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


        <div class="mt-4 page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Eventos Encerrados e Finalizados
                    </h2>
                </div>
                <!--<div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('liga-eventos-planejados') }}" class="btn btn-white">
                            Ver todos os planejados
                        </a>
                    </div>
                </div>-->
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
                                    <th>Data e Hora de Início</th>
                                    <th>Situação</th>
                                    <th>Organização</th>
                                    <th>Quorum mínimo / Inscritos</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($finish as $item)

                                <tr>
                                    <td><a href="{{ route('liga-evento-show',['id' => $item->id])}}">{{$item->name}}</a></td>
                                    <td class="text-muted">
                                        {{$item->startdate->format('d/m/y H:i')}}
                                    </td>
                                    <td class="text-muted">{{$item->status}}</td>
                                    <td class="text-muted">
                                        {{$item->team ? $item->team->name : 'Administração'}}
                                    </td>
                                    <td>
                                        {{$item->players}} / {{count($item->subscribers)}}
                                    </td>
                                    <td><a href="{{ route('liga-evento-edit-form',['id' => $item->id])}}">Editar</a></td>
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
