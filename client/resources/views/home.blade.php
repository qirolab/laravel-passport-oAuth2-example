@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!auth()->user()->token)
                        <a href="http://localhost/Projects/laravel-passport-oAuth2-example/client/public/oauth/redirect">Authorize from server</a>
                    @endif

                    @foreach ($posts as $post)
                        <div class="py-3 border-bottom">
                            <h3>{{ $post['title'] }}</h3>
                            <div>{{ $post['body'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
