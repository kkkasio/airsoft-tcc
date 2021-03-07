@extends('league.layouts.base')

@section('title', '- Inscrição Medir FPS')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Medição de FPS: {{$inscricao->profile->name}}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline-block">
                            <a href="{{ route('liga-evento-show',['id' => $inscricao->event->id]) }}"
                                class="btn d-none d-sm-inline-block">
                                Voltar para Evento
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form
                    action="{{ route('liga-event-inscricao-weapon-post', ['id' => $inscricao->event->id, 'inscricao' => $inscricao->id]) }}"
                    method="POST" class="card">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="weapon" class="form-label col-3 col-form-label">Armas</label>
                                <select class="form-select" id="weapon" name="weapon">
                                    @if($weapons)
                                    @foreach ($weapons as $weapon)
                                    <option value="{{$weapon->id}}">{{$weapon->name.' - '. $weapon->type }}</option>

                                    @endforeach
                                    @else
                                    <option value="">Sem Arma cadastrada</option>
                                    @endif
                                </select>
                                @error('weapon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fps" class="form-label col-3 col-form-label">FPS</label>
                                <input type="number" name="fps" class="form-control @error('fps') is-invalid @enderror"
                                    value="{{old('fps')}}">
                                @error('fps')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="note" class="form-label col-3 col-form-label">Observação</label>
                                    <textarea id="note" class="form-control" name="note"
                                        placeholder="Observação sobre algum ocorrido">{{old('note')}}</textarea>
                                    @error('note')
                                    <div>
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary ms-auto">Cronar Arma</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th>Inscrição</th>
                                    <th>Arma</th>
                                    <th>FPS</th>
                                    <th>OBS</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inscricao->weapons as $weapon)
                                <tr>
                                    <td>{{$inscricao->id}}</td>
                                    <td>
                                        {{$weapon->weapon->name}}
                                    </td>
                                    <td>
                                        {{$weapon->fps}}
                                    </td>
                                    <td>
                                        {{$weapon->obs ? $weapon->obs : '-'}}
                                    </td>
                                    <td>
                                        <form action="{{ route('liga-event-inscricao-weapon-remove')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="weapon" value="{{$weapon->id}}" />
                                            <button type="submit" class="btn btn-danger"><svg style="margin: 0"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <line x1="4" y1="7" x2="20" y2="7"></line>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg></button>
                                        </form>

                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nada cadastrado</td>
                                </tr>

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
