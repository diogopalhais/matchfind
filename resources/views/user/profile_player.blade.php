@extends('layouts.app')

@section('content')

  <div class="container">

    @if (Session::has('success'))
    	<div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><b>Player Profile</b></h3>
      </div>
      <div class="card-body">

        <div class="d-flex justify-content-start">

          <span class="avatar avatar-xxl" style="background-image: url({{$player->photo}})"></span>

          <div class="ml-4">
            <h3 class="mb-1">{{$player->name}}</h3>
            @if($player->location)
              <p class="text-muted"><i class="fe fe-map-pin"></i> {{$player->location}}</p>
            @endif
            @foreach ($player->sports as $sport)
              <span class="tag">{{$sport->name}}</span>
            @endforeach
          </div>

        </div>

      </div>

      </div>
    </div>


  </div>

@endsection
