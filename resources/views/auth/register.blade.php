@extends('layouts.auth')

@section('content')

<div class="container-tight py-6">
    <div class="text-center mb-4">
        <img src="{{url('/img/logo.png')}}" alt="SQUAD" width="25%"/>

    </div>

    <form method="POST" class="card card-md" action="{{ route('register') }}">
        @csrf
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Criar nova conta</h2>

            <div class="mb-3">
                <label for="email" class="form-label">Name</label>
                <input id="email" type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror" placeholder="Seu melhor email"
                    value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group input-group-flat">
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Sua senha secreta"
                        required autocomplete="new-password">

                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirmação de Senha</label>
                <div class="input-group input-group-flat">
                    <input id="password-confirm" type="password" class="form-control"
                        placeholder="Confirmação da senha secreta" name="password_confirmation" required
                        autocomplete="new-password">
                </div>
            </div>


            <div class="mb-3">
                <label class="form-label" for="">Qual o seu tipo de perfil?</label>

                <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                    <label class="form-selectgroup-item flex-fill">
                        <input type="radio" name="type" value="Membro" class="form-selectgroup-input">
                        @error('type')
                        <span>
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="form-selectgroup-label d-flex align-items-center p-3 @error('type') is-invalid @enderror">
                            <div class="me-3 mr-2">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div>
                                <span class="payment payment-provider-visa payment-xs me-2"></span>
                                Sou um <strong>membro</strong>
                            </div>
                        </div>
                    </label>
                    <label class="form-selectgroup-item flex-fill">
                        <input type="radio" name="type" value="Liga" class="form-selectgroup-input">
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3 mr-2">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div>
                                <span class="payment payment-provider-mastercard payment-xs me-2"></span>
                                Sou administrador de uma <strong>liga</strong>
                            </div>
                        </div>
                    </label>
                </div>

            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Register') }}
                </button>
            </div>


        </div>
    </form>
    <div class="text-center text-muted mt-3">
        Já tem uma conta <a href="login" tabindex="-1">Entrar</a>
    </div>
</div>

@endsection
