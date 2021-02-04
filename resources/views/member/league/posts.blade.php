@extends('member.layouts.base')

@section('title', '- Comunicados da Liga')

@section('content')

<div class="content">
    <div class="container-xl">
        <h2 class="page-title my-3">
            Comunicados da Liga: {{Auth::user()->profile->league->league->name}}
        </h2>

        <div class="row row-cards">
            @foreach ($posts as $post)
            <div class="col-md-4">
                <div class="card card-stacked">
                    <div class="card-header">
                        <div class="card-title">
                            {{$post->title}}

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-meta mt-1 d-flex justify-content-between">
                            <div class="card-subtitle">Data: {{$post->created_at->format('d/m/Y')}}</div>

                            @if($post->created_at != $post->updated_at)
                            <div class="card-subtitle">Atualizado em: {{$post->updated_at->format('d/m/Y')}}</div>
                            @endif


                        </div>
                        <div class="mb-2">
                            {{$post->content}}
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
