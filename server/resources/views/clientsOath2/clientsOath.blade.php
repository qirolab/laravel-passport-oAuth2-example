@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create OathClient') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{'oathClients'}}">
                        @csrf

                        <div class="form-group row">
                            <label for="App name" class="col-md-4 col-form-label text-md-right">{{ __('App Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required autofocus>
                             
                            </div>
                        </div>

                        

                        

                        <div class="form-group row">
                            <label for="Redirect Now" class="col-md-4 col-form-label text-md-right">{{ __('Redirect URL') }}</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" name="redirect_uri" required >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
