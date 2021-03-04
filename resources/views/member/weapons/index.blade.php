@extends('member.layouts.base')

@section('title', '- Minhas Armas')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Minhas Armas
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            <a href="#" id="form-modal" class="btn d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-add-weapon">
                                Nova Arma
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            @forelse (Auth::user()->profile->weapons as $weapon)

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-img-top img-responsive img-responsive-16by9"
                        style="background-image: url(https://baladasegura.rs.gov.br/themes/modelo-institucional/images/outros/GD_imgSemImagem.png)">
                    </div>

                    <div class="card-body p-4 text-center">

                        <h3 class="m-0 mb-1"><a href="#">{{$weapon->name}}</a></h3>
                        <div class="text-muted">{{$weapon->nickname}}</div>
                        <div class="mt-3">
                            <span class="badge bg-green-lt">{{$weapon->type}}</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="{{route('membro-me-weapon-edit-form',['id' => $weapon->id])}}" class="card-btn"><svg
                                xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                <line x1="16" y1="5" x2="19" y2="8"></line>
                            </svg>
                            Editar</a>
                        <a href="#" data-weapon="{{$weapon->id}}" data-bs-toggle="modal"
                            data-bs-target="#modal-remove" class="card-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill=""></path>
                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            </svg>
                            Remover</a>
                    </div>
                </div>
            </div>

            @empty
            <p>Nenhuma arma adicionada</p>
            @endforelse

        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-remove" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <form id="form-remove" method="POST" action="{{ route('membro-me-weapon-delete') }}" class="modal-content">
            @csrf
            <div class="modal-body">
                <div class="modal-title">Você tem certeza?</div>
                <div>Você gostaria de remover a arma?<p class="mt-1"> Não é possivel desfazer essa ação.</p>
                </div>
            </div>
            <input type="hidden" name="weapon" id="weapon" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">Cancelar</button>
                <button id="buttonRemove" type="submit" class="btn btn-danger" data-bs-dismiss="modal">Sim!
                    Remover</button>
            </div>
        </form>
    </div>
</div>


<div class="modal modal-blur fade" id="modal-add-weapon" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form id="form-add" action="{{ route('membro-me-weapon-post') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Adicionar nova arma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        placeholder="Ex: Ares Amoeba 009" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Apelido</label>
                    <input type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname"
                        placeholder="Sua arma tem um apelido?">
                    @error('nickname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


                <div class="mb-3">
                    <label id="type" class="form-label">Classe</label>
                    <select class="form-select" name="type" required>
                        <option value="Pistola">Pistola
                        </option>
                        <option value="Assault">Assault
                        </option>
                        <option value="Suporte">Suporte
                        </option>
                        <option value="DMR">DMR</option>
                        <option value="Sniper">Sniper</option>
                    </select>
                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button id="buttonAdd" type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Salvar
                </button>

            </div>
        </form>
    </div>
</div>

<script>
    $("[data-weapon]").click(function() {
        var id = $(this).attr('data-weapon');
        $('#weapon').val(id);
    });

    $("#buttonRemove").click(function(){

        $("#form-remove").submit();
    })


    $("#buttonAdd").click(function(){
        console.log('ok');
        $("#form-add").submit();
    })
</script>
@endsection
