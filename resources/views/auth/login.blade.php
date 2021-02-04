@extends('layouts.auth')

@section('content')
<div class="container-tight py-6">
    <div class="text-center mb-4">
        SQUAD
    </div>

    @if (Session::has('mensagem'))
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" data-bs-toggle="toast">
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
                        <a href="{{ route('password.request') }}">I forgot password</a>
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
        </div>
    </form>
    <div class="text-center text-muted mt-3">
        Ainda não tem uma conta? <a href="register" tabindex="-1">Criar Conta</a>
       </div>

</div>
@endsection
