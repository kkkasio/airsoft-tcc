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

        <div class="row row-cards">
            @foreach ($members as $member)
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url(./static/avatars/000m.jpg)">{{$member->profile->initials}}</span>
                        <h3 class="m-0 mb-1">{{$member->profile->name}}</h3>

                        <div class="text-muted">
                            @if($member->type === 'Moderador')
                            <span class="badge bg-purple-lt">
                                {{$member->type}}
                            </span>
                            @else
                            <span class="badge bg-green-lt">
                                {{$member->type}}
                            </span>
                            @endif
                        </div>

                        <div class="text-muted my-2">
                            @if($member->profile->team)
                            <span class="badge bg-blue-lt">
                                Time: {{$member->profile->team->team->name}}
                            </span>
                            @else
                            <span class="badge bg-green-lt">
                                Sem time
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


        <div class="modal modal-blur fade" id="modal-small" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <form id="form" method="POST" action="{{ route('liga-post-delete') }}" class="modal-content">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-title">Você tem certeza?</div>
                        <div>Você quer deletar esse comunicado? Não é possivel desfazer essa ação.</div>
                    </div>
                    <input type="hidden" name="post" id="post_id" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Sim! Deletar
                            comunicado</button>
                    </div>
                </form>
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
