@extends('member.layouts.base')

@section('title', '- Editar meu time')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title">
                        Editar Time
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md"
                    action="{{ route('membro-time-edit-post',['slug'=> $team->slug]) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label col-3 col-form-label">Nome do time</label>
                            <input id="name" type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Nome do time"
                                value="{{ old('name') || isset($team->name) ? $team->name : ''}}" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug" class="form-label col-3 col-form-label">Slug (url na plataforma)</label>
                            <div class="input-group input-group-flat">
                                <span class="input-group-text">
                                    {{ config('app.url')}}/time/
                                </span>
                                <input type="text" id="slug" name="slug"
                                    value="{{ old('slug') || isset($team->slug) ? $team->slug : '' }}"
                                    class="form-control @error('slug') is-invalid @enderror ps-1" autocomplete="off"
                                    {{isset($team->slug) ? 'disabled' : ''}} required>

                                @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if(isset($team->slug))
                            <div class="form-check-label">Você não pode alterar esse campo</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="about" class="form-label col-3 col-form-label">Sobre o time</label>
                            <textarea id="about" class="form-control @error('about') is-invalid @enderror" name="about"
                                placeholder="Conte um pouco da história do time"
                                required>{{ old('about') || isset($team->about) ? $team->about : '' }}</textarea>
                            @error('about')
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

        <div class="col mt-4">
            <div class="page-title">
                Membros
            </div>
        </div>
        <div class="row row-cards">
            @foreach ($members as $member)

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url(./static/avatars/000m.jpg)">{{$member->profile->initials}}</span>
                        <h3 class="m-0 mb-1">{{$member->profile->name}}</h3>

                        <div class="text-muted">
                            @if($member->type === 'Moderador')
                            <span class="badge bg-purple-lt">
                                {{$member->type}}
                            </span>
                            @else
                            <span class="badge bg-green-lt">
                                {{$member->type}}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('membro-time-edit-member-form',['slug' => $team->slug,'id'=> $member->id])}}"
                            class="card-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                <line x1="16" y1="5" x2="19" y2="8"></line>
                            </svg>
                            Editar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
