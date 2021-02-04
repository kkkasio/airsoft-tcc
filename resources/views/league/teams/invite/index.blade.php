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
                        Gerar convite para time
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#modal-report">
                            Gerar código de convite
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
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Data de Criação</th>
                                    <th>Foi usado?</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invites as $invite)
                                <tr>
                                    <td>{{$invite->id}}</td>
                                    <td class="text-muted user-select-all">
                                        {{$invite->code}}
                                    </td>
                                    <td class="text-muted">
                                        {{$invite->created_at->format('d/m/Y - G:m')}}
                                    </td>
                                    <td class="text-muted">
                                       {{$invite->used ? 'Sim': 'Não'}}
                                    </td>
                                    <td>
                                        {{$invite->team ? $invite->team->name : '-'}}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center mt-3">Nenhum convite criado</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <form id="form" action="{{ route('liga-times-create-invite') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Gerar código de convite</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Código</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                placeholder="Se preferir deixe em branco">
                        </div>
                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </a>
                        <button id="sendForm" type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Gerar código
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    $("button[type=submit").click(function(){
        $("form").submit();
    })
</script>

@endsection
