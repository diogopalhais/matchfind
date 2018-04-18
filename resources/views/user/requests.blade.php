@extends('layouts.app')

@section('content')

  <div class="container">

    @if (Session::has('success'))
    	<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"></button>
        <i class="fe fe-check mr-2" aria-hidden="true"></i> {{ Session::get('success') }}
      </div>
    @endif

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><b>Requests</b></h3>
      </div>
      <ul class="list-group list-group-flush">
        @if(\Auth::user()->requests->count()==0)
          <li class="list-group-item">
            <small class="text-muted">
              You don't have sent any request yet
            </small>
          </li>
        @endif
      @foreach (\Auth::user()->requests as $request)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <div>
               You sent a request to join the
               <a href="/events/{{$request->game->id}}">event</a>
               <br>
               <small class="text-muted">
                 {{\Carbon\Carbon::parse($request->created_at)->diffforhumans()}}
               </small>
            </div>
            @if($request->state==0)
              <span class="tag">Pending</span>
            @elseif($request->state==1)
              <span class="tag tag-green">Accepted</span>
            @elseif($request->state==2)
              <span class="tag tag-red">Rejected</span>
            @endif
          </div>
        </li>
      @endforeach
      </ul>

  </div>

@endsection
