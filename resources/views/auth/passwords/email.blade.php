@extends('member.layouts.simple')

@section('title','Redefinir Senha')

@section('content')

<div class="page page-center">
    <div class="container-tight py-4">
        <div class="text-center mb-4">
            <a href="."><img src="./static/logo.svg" alt=""></a>
            <img src="{{url('/img/logo.png')}}" alt="SQUAD" height="36" />
        </div>

        @if (session('status'))

        <div class="alert alert-success" role="alert">
            <h4 class="alert-title">Sucesso!</h4>
            <div class="text-muted">{{session('status')}}</div>
        </div>

        @endif
        
        <form class="card card-md" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="card-body">
                <p class="text-muted mb-4">
                    Digite seu endereço de e-mail e sua senha será redefinida e enviada para você por e-mail.
                </p>

                <div class="mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>



        </form>

        <div class="text-center text-muted mt-3">
            <a href="{{route('login') }}">Voltar para o login</a>
        </div>
    </div>
</div>

@endsection
