@extends('league.layouts.base')

@section('title', '- Criar Evento')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Editar Perfil
                    </h2>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md" action="{{ route('liga-me-edit-post') }}">
                    @csrf
                    <div class="card-body">


                        <div class="form-group">
                            <label for="name" class="form-label col-3 col-form-label">Nome da Liga</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name') ? old('name') : Auth::user()->league->name}}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">

                            <label for="about" class="form-label col-3 col-form-label">Nome da Liga</label>
                            <textarea type="text" id="about" name="about" value="{{old('about')}}"
                                class="form-control @error('about') is-invalid @enderror"
                                required>{{ old('about') ? old('about') : Auth::user()->league->about  }}</textarea>
                            @error('about')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="slug" class="form-label col-3 col-form-label">Slug (url na plataforma)</label>
                            <div class="input-group input-group-flat">
                                <span class="input-group-text">
                                    https://localhost.com/league/
                                </span>
                                <input type="text" id="slug" name="slug"
                                    value="{{ Auth::user()->league->slug ? Auth::user()->league->slug : '' }}"
                                    class="form-control @error('slug') is-invalid @enderror ps-1" autocomplete="off"
                                    <?php echo Auth::user()->league->slug ? 'disabled': '' ?> required>

                                @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if(Auth::user()->league->slug)
                            <div class="form-check-label">Você não pode alterar esse campo</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="rm-label col-3 col-form-label">Data de Fundação</label>
                            <input type="text" name="foundation" required
                                class="form-control @error('foundation') is-invalid @enderror" data-mask="00/00/0000"
                                value={{ old('foundation') ? old('foundation') : Auth::user()->league->foundation->format('d/m/Y') }}
                                data-mask-visible="true" placeholder="00/00/0000" value="{{ old('foundation') }}"
                                autocomplete="off">
                            @error('foundation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="rm-label col-3 col-form-label">Selecione um estado</div>
                            <select name="estado" required class="form-select @error('estado') is-invalid @enderror">
                                @foreach ($states as $state)
                                <option value="{{$state->id}}"
                                    {{Auth::user()->league->state_id === $state->id ? 'selected':''}}>
                                    {{$state->title}}</option>

                                @endforeach

                            </select>
                            @error('estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="rm-label col-3 col-form-label">Selecione a cidade</div>
                            <select name="cidade" required class="form-select @error('cidade') is-invalid @enderror">
                                @foreach ($cities as $city)
                                <option value="{{$city->id}}"
                                    {{Auth::user()->league->city_id === $city->id ? 'selected':''}}>
                                    {{$city->title}}</option>
                                @endforeach
                            </select>
                            @error('cidade')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Atualizar Perfil
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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


</script>


@endsection
