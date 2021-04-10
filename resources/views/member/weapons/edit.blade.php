@extends('member.layouts.base')

@section('title', '- Editar Arma')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Editar Arma
                    </h2>
                </div>


                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            <a href="{{ route('membro-me-weapon-all')}}" class="btn btn-white">
                                Voltar para a Listagem
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md"
                    action="{{ route('membro-me-weapon-update', ['id'=> $weapon->id])}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label col-3 col-form-label">Nome</label>
                            <input id="name" type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Nome do time"
                                value="{{ old('name') || isset($weapon->name) ? $weapon->name : ''}}" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nickname" class="form-label col-3 col-form-label">Apelido</label>
                            <input id="nickname" type="text" name="nickname"
                                class="form-control @error('nickname') is-invalid @enderror" placeholder="Nome do time"
                                value="{{ old('nickname') || isset($weapon->nickname) ? $weapon->nickname : ''}}"
                                required>
                            @error('nickname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label id="type" class="form-label">Classe</label>
                            <select class="form-select" name="type" required>
                                <option value="Pistola" {{$weapon->type === 'Pistola' ? 'selected': ''}}>Pistola
                                </option>
                                <option value="Assault" {{$weapon->type === 'Assault' ? 'selected': ''}}>Assault
                                </option>
                                <option value="Suporte" {{$weapon->type === 'Suporte' ? 'selected': ''}}>Suporte
                                </option>
                                <option value="DMR" {{$weapon->type === 'DMR' ? 'selected': ''}}>DMR</option>
                                <option value="Sniper" {{$weapon->type === 'Sniper' ? 'selected': ''}}>Sniper
                                </option>
                            </select>
                            @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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






@endsection
