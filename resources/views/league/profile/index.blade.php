@extends('league.layouts.base')

@section('title', '- Meu Perfil')

@section('content')

<div class="content">
    <div class="container-xl">

        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Perfil
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn btn-white">
                                Editar Perfil
                            </a>
                        </span>
                        <!-- <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Create new report
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#modal-report" aria-label="Create new report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a> -->
                    </div>
                </div>
            </div>

        </div>


        <div class="row row-cards">
            <div class="col-md-4 col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Informações</div>

                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                            </svg>
                            URL: <strong><?php echo config('app.url')."/liga/{$league->slug}" ?></strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                <line x1="16" y1="3" x2="16" y2="7"></line>
                                <line x1="8" y1="3" x2="8" y2="7"></line>
                                <line x1="4" y1="11" x2="20" y2="11"></line>
                                <line x1="11" y1="15" x2="12" y2="15"></line>
                                <line x1="12" y1="15" x2="12" y2="18"></line>
                            </svg>
                            Data de Fundação: <strong>{{ date('d/m/Y', strtotime($league->foundation)) }}</strong>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <polyline points="12 7 12 12 15 15"></polyline>
                            </svg>
                            Localização: <strong>{{ $league->state->letter}}</strong> -
                            <strong>{{ $league->city->title }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-6 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Sobre</div>
                        <div class="mb-2">
                            {{ $league->about }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col my-4">
            <h2 class="page-title">
                Comunicados
            </h2>

        </div>

        <div class="row row-cards">



            @forelse (Auth::user()->league->posts as $post)
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
