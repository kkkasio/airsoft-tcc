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
                        Membros do time - {{$teamLeague->team->name}} ({{count($teamLeague->team->members)}})
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Time</th>
                                <th>É membro da liga?</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teamLeague->team->members as $member)
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2"
                                            style="background-image: url(./static/avatars/006m.jpg)">{{$member->profile->avatar ? '' : $member->profile->initials}}</span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{$member->profile->name}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{$member->profile->team ? $member->profile->team->team->name : ''}}</div>
                                    <div class="text-muted">
                                        {{$member->profile->team ? $member->profile->team->type : ''}}</div>
                                </td>
                                <td class="text-muted">
                                    {{$member->profile->league->league_id === Auth::user()->league->id ? 'Sim' : 'Não'}}
                                </td>
                                <td>
                                    @if ($member->profile->league->league_id ===
                                    Auth::user()->league->id)
                                    <a href="#" data-post-modal="{{$member->profile->id}}" data-bs-toggle="modal"
                                        data-bs-target="#modal-remove">Remover
                                        da liga</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-remove" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            <div class="modal-status bg-danger"></div>
            <form id="form" method="POST" action="{{ route('liga-membro-remove') }}" class="modal-content">
                @csrf
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 9v2m0 4v.01"></path>
                        <path
                            d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75">
                        </path>
                    </svg>
                    <h3>Você tem certeza?</h3>
                    <div class="text-muted">Você deseja remover o membro da liga?
                    </div>
                </div>
                <input type="hidden" name="profile" id="profile" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Sim! Remover</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("[data-post-modal]").click(function() {
        var id = $(this).attr('data-post-modal');
        $('#profile').val(id);
    });

    $("button[type=submit").click(function(){
        $("form").submit();
    })
</script>

@endsection
