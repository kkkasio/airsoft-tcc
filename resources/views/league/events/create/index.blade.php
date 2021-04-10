@extends('league.layouts.base')

@section('title', '- Criar Evento')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Criar novo Evento
                    </h2>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="POST" class="card card-md" class="card card-md"
                    action="{{ route('liga-eventos-post') }}">
                    @csrf
                    <div class="card-body">
                        @include('league.events._form')
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Criar Evento
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
          plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
          toolbar: 'undo redo | checklist | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
          toolbar_mode: 'floating',
          language: 'pt_BR'
    });
</script>

@endsection
