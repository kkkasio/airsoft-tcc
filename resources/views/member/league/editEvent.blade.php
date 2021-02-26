@extends('member.layouts.base')

@section('title', '- Editar Evento')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Editar Evento: {{$event->name}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="POST" class="card card-md" class="card card-md"
                    action="{{ route('member-evento-update',['id' => $event->id]) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="name" class="form-label col-3 col-form-label">Nome da missão</label>
                                <input type="text" id="name" name="name"
                                    value="{{old('name') ? old('name') : $event->name }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Foto</label>
                                <input type="file" id="avatar" name="avatar"
                                    class="form-control @error('avatar') is-invalid @enderror">
                                <small class="form-hint">@if($event->avatar) <a
                                        href="{{ url('/storage/avatars/'.$event->avatar) }}" target="_blank">Visualizar
                                        Avatar</a> - Preencha esse campo apenas se quiser <strong>ATUALIZAR</strong> o
                                    avatar do evento.</small> @endif
                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="startdate" class="form-label col-3 col-form-label">Data e hora de
                                    início</label>
                                <input type="datetime-local" id="startdate" name="startdate"
                                    class="form-control @error('startdate') is-invalid @enderror"
                                    value="{{old('startdate') ? old('startdate') :  $event->startdate->format('Y-m-d\TH:i') }}"
                                    autocomplete="off" required>

                                @error('startdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="enddate" class="form-label col-3 col-form-label">Data e hora de
                                    encerramento</label>
                                <input type="datetime-local" id="enddate" name="enddate"
                                    class="form-control @error('enddate') is-invalid @enderror"
                                    value="{{old('enddate') ? old('enddate') :  $event->enddate->format('Y-m-d\TH:i') }}"
                                    autocomplete="off" required>

                                @error('enddate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="mb-3">
                                <label for="players" class="form-label col-3 col-form-label">Mínimo de Jogadores</label>
                                <input type="number" id="players" name="players"
                                    value="{{old('players') ? old('players') : $event->players }}"
                                    class="form-control @error('players') is-invalid @enderror" required>

                                @error('players')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="about" class="form-label col-3 col-form-label">Sobre o jogo</label>
                                <textarea id="about" class="tinymce form-control" name="about"
                                    placeholder="Breve descrição sobre o evento..">{{old('about') ? old('about') : $event->about }}</textarea>
                                @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="Aberto" {{$event->status === 'Aberto' ? 'selected' : ''}}>Aberto
                                    </option>
                                    <option value="Planejado" {{$event->status === 'Planejado' ? 'selected' : ''}}>
                                        Planejado</option>
                                    <option value="Inscrições Encerradas"
                                        {{$event->status === 'Inscrições Encerradas' ? 'selected' : ''}}>
                                        Encerrado</option>
                                </select>
                                @error('status')
                                <span class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="mb-3">
                                <label for="file" class="form-label col-3 col-form-label">PDF da Missão</label>
                                <input type="file" id="file" name="file"
                                    class="form-control @error('file') is-invalid @enderror">
                                <small class="form-hint">@if($event->file) <a
                                        href="{{Storage::url('/files/'.$event->file)}}" target="_blank">Visualizar
                                        Avatar</a> - Preencha esse campo apenas se quiser <strong>ATUALIZAR</strong> o
                                    PDF da missão.</small> @endif

                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Atualizar Evento
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.tiny.cloud/1/urpafxeez855sb5p97yda09t1a3ymbrpu9xsv4z72cbgbe46/tinymce/5/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
          selector: '#about',
          //menubar: 'edit  view  format tools'
          plugins: 'casechange formatpainter linkchecker autolink lists checklist  permanentpen powerpaste  tinymcespellchecker',
          toolbar: 'undo redo | checklist | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
          toolbar_mode: 'floating',
          language: 'pt_BR'
    });
</script>

@endsection
