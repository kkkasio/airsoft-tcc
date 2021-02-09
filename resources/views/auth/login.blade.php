@extends('layouts.auth')

@section('content')
<div class="container-tight py-6">
    <div class="text-center mb-4">
        SQUAD
    </div>

    @if (Session::has('mensagem'))
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"
        data-bs-toggle="toast">
        <div class="toast-header">
            <button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ Session::get('mensagem') }}
        </div>
    </div>

    @endif

    <form method="POST" action="{{ route('login') }}" class="card card-md">
        @csrf
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Login to your account</h2>

            <div class="mb-3">
                <label for="email" class="form-label">E-Mail</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    placeholder="Seu melhor e-mail" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">{{ __('Password') }}
                    @if (Route::has('password.request'))
                    <span class="form-label-description">
                        <a href="{{ route('password.request') }}">Esqueci minha senha</a>
                    </span>

                    @endif

                </label>
                <input id="password" type="password" placeholder="Sua senha secreta"
                    class="form-control @error('password') is-invalid @enderror" name="password" required
                    autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="form-check-label">Manter conectado</label>
                </label>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="hr-text">ou</div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="{{ url('auth/google') }}" class="btn btn-white w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-google"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M17.788 5.108a9 9 0 1 0 3.212 6.892h-8"></path>
                            </svg>
                            Login com Google
                        </a>
                    </div>
                    <div class="col"><a href="{{ url('auth/github') }}" class="btn btn-white w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-github" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5">
                                </path>
                            </svg>
                            Login com Github
                        </a></div>
                </div>
            </div>
        </div>

    </form>
    <div class="text-center text-muted mt-3">
        Ainda não tem uma conta? <a href="register" tabindex="-1">Criar Conta</a>
    </div>

</div>
@endsection
