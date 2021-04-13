@extends(($user->type === 'Liga') ? 'league.layouts.base' : 'member.layouts.base')

@section('title', '- Alterar Senha')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Atualizar Senha
                    </h2>
                </div>

            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md" action="{{ route('update-password') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label col-3 col-form-label">Senha Atual</label>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Sua Senha atual" value="{{ old('password') }}" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nickname" class="form-label col-3 col-form-label">Nova Senha</label>
                            <input id="new_password" type="password" name="new_password"
                                class="form-control @error('new_password') is-invalid @enderror"
                                placeholder="Nova senha" required>
                            @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nickname" class="form-label col-3 col-form-label">Confirmação da Senha</label>
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                placeholder="Confirmação da Senha" required>
                            @error('new_password_confirmation')
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
