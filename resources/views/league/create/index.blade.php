@extends('league.layouts.simple')


@section('content')

<div class="container-tight py-6">
    <div class="text-center mb-4">
        SQUAD
    </div>
    <form method="POST" class="card card-md" action="{{ route('criarliga') }}">
        @csrf
        <div class="card-body text-center py-2 p-sm-4">
            <h1 class="mt-5">Bem vindo ao SQUAD!</h1>
            <p class="text-muted">Agora iremos criar o perfil para sua liga!</p>
        </div>
        <div class="hr-text hr-text-center hr-text-spaceless">Dados da liga</div>
        <div class="card-body">
            <div class="mb-3">
                <div class="form-label">
                    <label for="name" class="form-label">Nome da liga*</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Qual o nome da liga?" autocomplete="off" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug (url na plataforma)</label>
                <div class="input-group input-group-flat">
                    <span class="input-group-text">
                        https://localhost.com/liga/
                    </span>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="form-control @error('slug') is-invalid @enderror ps-1"
                        autocomplete="off" required>
                    @error('slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Criação</label>
                <input type="text" name="foundation" required class="form-control @error('foundation') is-invalid @enderror" data-mask="00/00/0000"
                    data-mask-visible="true" placeholder="00/00/0000" value="{{ old('foundation') }}"
                    autocomplete="off">
                @error('foundation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-label">Selecione um estado</div>
                <select name="estado" required class="form-select @error('estado') is-invalid @enderror">
                    <option>Carregando...</option>

                </select>
                @error('estado')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-label">Selecione a cidade</div>
                <select name="cidade" required class="form-select @error('cidade') is-invalid @enderror">
                    <option>Selecione um estado</option>

                </select>
                @error('cidade')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Conte um pouco sobre a liga
                    <!--<span class="form-label-description">56/100</span>--></label>
                <textarea class="form-control @error('about') is-invalid @enderror" name="about" rows="6" value="{{ old('about') }}" required
                    placeholder="Escreva aqui.."></textarea>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    Criar Liga
                </button>
            </div>

        </div>

    </form>
</div>

<script>
    $( document ).ready(function() {
        $.get( "/estados", function( response ) {
            $('select[name=estado]').empty();
        $.each(response, function (key,value){
            $('select[name=estado]').append('<option value=' + value.id + '>' + value.title + '</option>');
        })
    });

    $('select[name=estado]').change(function () {
            var idEstado = $(this).val();
            $.get('/get-cidades/' + idEstado, function (cidades) {
                console.log(cidades)
                $('select[name=cidade]').empty();
                $.each(cidades, function (key, value) {
                    $('select[name=cidade]').append('<option value=' + value.id + '>' + value.title + '</option>');
                });
            });
        });
});

</script>

@endsection
