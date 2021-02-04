@extends('league.layouts.base')

@section('title', '- Exibindo todos os Comunicados')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Todos os Comunicados
                    </h2>
                </div>
            </div>
        </div>



        <div class="row row-cards">
            @forelse ($posts as $post)
            <div class="col-md-4">
                <div class="card card-stacked">
                    <div class="card-header">
                        <div class="card-title">
                            {{$post->title}}

                        </div>
                        <div class="card-actions">
                            <div class="dropdown">
                                <a href="#" class="card-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('liga-post-edit-form',['id'=> $post->id]) }}"
                                        class="dropdown-item">Editar</a>
                                    <a href="#" class="dropdown-item" data-post-modal="{{$post->id}}"
                                        data-bs-toggle="modal" data-bs-target="#modal-small">
                                        Deletar
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="card-meta d-flex justify-content-between">
                            <div class="card-subtitle">Data: {{$post->created_at->format('d/m/Y')}}</div>

                            @if ($post->created_at != $post->updated_at)

                            <div class="card-subtitle">Atualizado em: {{$post->updated_at->format('d/m/Y')}}</div>
                            @endif


                        </div>
                        <div class="mb-2">
                            {{$post->content}}
                        </div>

                    </div>
                </div>
            </div>
            @empty
            <p>Nenhum comunicado...</p>
            @endforelse
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
