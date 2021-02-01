@extends('league.layouts.base')

@section('title', '- Editar Comunicado')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Editar Comunicado
                    </h2>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md"
                    action="{{ route('liga-post-edit',['id' => $post->id]) }}">

                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="form-label col-3 col-form-label">Título</label>
                            <input id="title" type="text" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Título do comunicado"
                                value="{{ old('title') ? old('title') : $post->title }}" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="hidden" name="id" value="{{$post->id}}">

                        <div class="form-group">
                            <label for="content" class="form-label col-3 col-form-label">Conteúdo</label>
                            <textarea id="content" class="form-control @error('content') is-invalid @enderror"
                                name="content" placeholder="Conteúdo da do comunicado"
                                required>{{ old('content') ? old('content') : $post->content }}</textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
