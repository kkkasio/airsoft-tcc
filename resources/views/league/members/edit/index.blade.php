@extends('league.layouts.base')

@section('title', '- Exibindo Membros da liga')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title">
                        Editar membro: {{$member->profile->name}}
                    </div>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            <a href="#" class="btn btn-red" data-bs-toggle="modal" data-bs-target="#modal-danger">
                                Remover membro da liga
                            </a>
                        </span>
                    </div>
                </div>

            </div>

        </div>
        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md"
                    action="{{ route('liga-membro-update', ['id' => $member->id])}}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <div for="type" class="form-label col-3 col-form-label">Permissões na liga</div>
                                <select class="form-select" name="type" id="type">
                                    <option value="Moderador" {{$member->type === 'Moderador' ? 'selected' : ''}}>Moderador</option>
                                    <option value="Membro" {{$member->type === 'Membro' ? 'selected' : ''}}>Membro</option>
                                </select>

                                @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Atualizar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-blur fade" id="modal-danger" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <form id="form-delete" action="#" method="POST" class="modal-content">
            @csrf
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 9v2m0 4v.01"></path>
                    <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75">
                    </path>
                </svg>
                <h3>Você tem certeza?</h3>
                <div class="text-muted">Gostaria de remover o membro da liga?</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn btn-white w-100" data-bs-dismiss="modal">
                                Cancelar
                            </a></div>
                        <div class="col">
                            <a id="sendForm" href="#" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                Remover membro
                            </a></div>
                    </div>
                </div>
            </div>
    </div>
</div>
</div>


<script>
    $('#sendForm').on('click', function(){
        $('#form-delete').submit();
    })
</script>

@endsection
