@extends('member.layouts.base')

@section('title', '- Editar membro do time')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title">
                        Editar membro: {{$profile->name}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md" action="#">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <div for="type" class="form-label col-3 col-form-label">Permissões no time</div>
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


@endsection
