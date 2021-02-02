@extends('member.layouts.base')

@section('title', '- Editar Perfil')

@section('content')


<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title">
                        Editar Perfil
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md" action="{{ route('membro-me-edit-post') }}">
                    @csrf
                    <div class="card-body">
                        @include('member.profile._form')
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Criar time
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
