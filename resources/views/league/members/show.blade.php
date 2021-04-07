@extends('league.layouts.base')

@section('title', '- Exibindo Membros da liga')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Todos os Membros ({{count($members)}})
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
                                <th>Regra</th>
                                <th>Última Participação</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">

                                        <span class="avatar me-2"
                                            style="background-image: url({{$member->profile->avatar ? '/storage/avatars/'.$member->profile->avatar : ''}})">{{$member->profile->avatar ? '' : $member->profile->initials}}</span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{$member->profile->name}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($member->profile->team)
                                    <div>{{$member->profile->team->team->name}}</div>
                                    <div class="text-muted">
                                        {{$member->profile->team->type}}</div>

                                    @else
                                    <div>Sem Time</div>
                                    @endif

                                </td>
                                <td class="text-muted">
                                    {{$member->type}}
                                </td>
                                <td>
                                    @if($member->profile->events->last())
                                    <div class="text-muted">
                                        {{ $member->profile->events->last()->event->name }}
                                        ({{$member->profile->events->last()->created_at->format('d/m/Y')}})
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('liga-membro-show',['id' => $member->id])}}">Editar</a>
                                </td>
                            </tr>



                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-itens-center">
                    <p class="m-0 text-muted">Exibindo <span>{{$members->count()}}</span> de
                        {{$members->total()}}
                        em <span>{{$members->lastPage()}}</span> páginas</p>
                    <ul class="pagination m-0 ms-auto">

                        {{$members->render()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("[data-post-modal]").click(function() {
        var id = $(this).attr('data-post-modal');
        $('#post_id').val(id);
    });

    $("button[type=submit").click(function(){
        $("form").submit();
    })
</script>

@endsection
