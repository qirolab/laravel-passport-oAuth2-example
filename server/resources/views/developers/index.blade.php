@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hi {{ Auth::user()->name }} Welcome to the Developers Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif



                   
        <div class="container shadow p-3 mb-5 bg-white rounded">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6">
          OAuth Clients
          </div>
          <div class="col-sm-12 col-md-6 col-xs-6 col-lg-6">
         <a href="{{route('showView')}}"> Create New Client</a>
          </div>
         
        </div>
        
        <div class="card-header">
       
        You have not created any OAuth client.
</div>


      </div>




      <div class="container shadow p-3 mb-5 bg-white rounded">
      <div class="row">
          <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6">
          Personal Access Tokens
          </div>
          <div class="col-sm-12 col-md-6 col-xs-6 col-lg-6">
         <a href="{{route('tokenPersonalInsert')}}"> Create New Token </a>
          
          </div>
         
        </div>
        <hr>
        <div class="card-header">
        You have not created any personal access tokens.
       
</div>
</div>







      

        </div>
    </div>
</div>                 
                 
@endsection
