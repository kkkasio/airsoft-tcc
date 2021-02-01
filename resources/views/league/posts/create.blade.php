@extends('league.layouts.base')


@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Criar novo Comunicado
                    </h2>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" class="card card-md" class="card card-md" action="{{ route('liga-post-create') }}">
                    @csrf
                    <div class="card-body">
                        @include('league.posts._form')
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Criar comunicado
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
