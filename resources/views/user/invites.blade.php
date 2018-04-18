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
        <h3 class="card-title"><b>Invites</b></h3>
      </div>
      <ul class="list-group list-group-flush">
      @if(\Auth::user()->invites->count()==0)
        <li class="list-group-item">
          <small class="text-muted">
            You don't have any invite
          </small>
        </li>
      @endif
      @foreach (\Auth::user()->invites as $request)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center">
               <span class="avatar" style="background-image: url({{$request->game->user->photo}})"></span>
               <div class="ml-3 d-flex flex-column justify-content-between">
                 <div>
                   <a href="/player/{{$request->game->user->id}}"><b>{{$request->game->user->name}}</b></a>
                 sent you a invite to join the
                 <a href="/events/{{$request->game->id}}">event</a>
               </div>
                 <small class="text-muted">
                   {{\Carbon\Carbon::parse($request->created_at)->diffforhumans()}}
                 </small>
               </div>
            </div>
            <div>
            @if($request->state==0)
              <span class="tag">Pending</span>
            @elseif($request->state==1)
              <span class="tag tag-green">Attending</span>
            @elseif($request->state==2)
              <span class="tag tag-red">Rejected</span>
            @endif
            <div class="dropdown">
              <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                 Manage
              </button>
              <div class="dropdown-menu">
                @if($request->state==0)
                  <a class="dropdown-item" href="/events/{{$request->game->id}}/player/{{$request->id}}/accept">Accept</a>
                  <a class="dropdown-item" href="/events/{{$request->game->id}}/player/{{$request->id}}/reject">Reject</a>
                @elseif($request->state==1)
                  <a class="dropdown-item" href="/events/{{$request->game->id}}/player/{{$request->id}}/reject">Reject</a>
                @elseif($request->state==2)
                  <a class="dropdown-item" href="/events/{{$request->game->id}}/player/{{$request->id}}/accept">Accept</a>
                @endif
              </div>
          </div>
          </div>
          </div>
        </li>
      @endforeach
      </ul>

  </div>

@endsection
