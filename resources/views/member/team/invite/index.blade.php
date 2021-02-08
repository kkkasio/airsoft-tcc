@extends('member.layouts.base')

@section('title', '- Dashboard')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Convite para time
                    </h2>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md"
                    action="{{ route('member-team-invite-post') }}">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="code" class="form-label col-3 col-form-label">Código</label>
                            <input id="code" type="text" name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                placeholder="Código de convite" value="{{ old('code') }}"
                                required>
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
