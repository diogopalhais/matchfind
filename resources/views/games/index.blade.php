@extends('layouts.app')

@section('content')

  <div class="container">

    @if (Session::has('success'))
    	<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"></button>
        <i class="fe fe-check mr-2" aria-hidden="true"></i> {{ Session::get('success') }}
      </div>
    @endif

    <div class="row">
              <div class="col-md-3">
                <h3 class="page-title mb-5">Events</h3>
                <div>
                  <div class="mb-6">
                    <a href="/events/new" class="btn btn-primary btn-block">
                    <i class="fe fe-plus mr-2"></i> Create New
                    </a>
                  </div>
                  <div class="list-group list-group-transparent mb-6">
                    <a href="/events" class="list-group-item list-group-item-action d-flex align-items-center @if(\Request::path()=='events') active @endif">
                      <span class="icon mr-3"><i class="fe fe-chevron-right"></i></span>
                      <small><b>NEXT EVENTS</b></small>
                      <span class="ml-auto tag">{{$games->total()}}</span>
                    </a>
                    <a href="/my-events" class="list-group-item list-group-item-action d-flex align-items-center @if(\Request::path()=='my-events') active @endif">
                      <span class="icon mr-3">
                        <i class="fe fe-chevron-right"></i></span>
                        <small><b>MY EVENTS</b></small>
                        <span class="ml-auto tag">{{\Auth::user()->myGames->count()}}</span>
                    </a>
                    <a href="/attending" class="list-group-item list-group-item-action d-flex align-items-center @if(\Request::path()=='attending') active @endif">
                      <span class="icon mr-3">
                        <i class="fe fe-chevron-right"></i></span>
                        <small><b>ATTENDING</b></small>
                        <span class="ml-auto tag">{{\Auth::user()->attending->count()}}</span>
                    </a>
                    <a href="/pending" class="list-group-item list-group-item-action d-flex align-items-center @if(\Request::path()=='pending') active @endif">
                      <span class="icon mr-3">
                        <i class="fe fe-chevron-right"></i></span>
                        <small><b>PENDING</b></small>
                        <span class="ml-auto tag">{{\Auth::user()->pending->count()}}</span>
                    </a>
                  </div>

                </div>
              </div>
              <div class="col-md-9">

                <div class="card">

                  <div class="card-header">
                    <h3 class="card-title"><b>
                      @if(\Request::path()=='events')
                        Next Events
                      @elseif(\Request::path()=='my-events')
                        My Events
                      @elseif(\Request::path()=='attending')
                        Attending
                      @elseif(\Request::path()=='pending')
                        Pending
                      @endif
                    </b></h3>
                  </div>
                  <div class="list-group list-group-flush">
                @if($games->count()==0)
                  <li class="list-group-item">
                    <small class="text-muted">
                      There is no events for now
                    </small>
                  </li>
                @endif
                @foreach ($games->sortBy('date') as $game)

                  @php
                    if(\Request::path()=='attending' OR \Request::path()=='pending'){
                      $game = $game->game;
                    }
                  @endphp

                    <a href="/events/{{$game->id}}" class="list-group-item list-group-item-action">
                      <div class="d-flex justify-content-start">
                        <div style="background:#f8f9fa;border:none" class="card mb-0 col-sm-4 col-md-4 col-lg-3 col-xl-2 d-none d-sm-flex mr-4">
                          <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <div class="text-muted">{{ \Carbon\Carbon::parse($game->date)->format('D') }}</div>
                            <div class="h1 m-0">{{ \Carbon\Carbon::parse($game->date)->format('d') }}</div>
                            <div class="text-muted">{{ \Carbon\Carbon::parse($game->date)->format('M y') }}</div>
                          </div>
                        </div>
                        <div class="col-sm-8 col-md-8 col-lg-9 col-xl-10 col-xs-12 flex-column">
                          <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-1">{{$game->title}}</h3>
                            <span class="tag mt-1">{{$game->sport->name}}</span>
                          </div>
                          <div class="text-muted"><i class="fe fe-clock"></i>   {{ \Carbon\Carbon::parse($game->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($game->time_end)->format('H:i') }}
                          &nbsp;  • &nbsp; <i class="fe fe-dollar-sign"></i>{{ $game->cost }} per player</div>
                          <div class="text-muted d-sm-none d-flex"><i class="fe fe-calendar"></i> &nbsp;  {{ \Carbon\Carbon::parse($game->date)->format('D, d M y') }}</div>
                          <div class="text-muted"><i class="fe fe-map-pin"></i>  {{$game->local}}</div>
                          <div class=" d-flex justify-content-start mt-3">
                            <div class="d-flex flex-column align-items-center">
                              <span class="avatar avatar-green">{{$game->attending->count() + $game->num_players_confirmed}}</span>
                              <small style="font-size:10px" class="text-muted"><b>ATTENDING</b></small>
                            </div>
                            <div class="d-flex flex-column align-items-center ml-3">
                              <span class="avatar avatar-gray">{{$game->num_players  - ($game->attending->count() + $game->num_players_confirmed) }}</span>
                              <small style="font-size:10px" class="text-muted"><b>SPOTS LEFT</b></small>
                            </div>
                            @if($game->user->id == \Auth::user()->id)
                              <div class="d-flex align-items-center ml-5">
                                <span class="status-icon bg-secondary"></span>
                                <small class="text-muted"><b>Your Event</b></small>
                              </div>
                            @endif
                            @if($game->players->where('user_id',\Auth::user()->id)->first())
                              @if($game->players->where('user_id',\Auth::user()->id)->first()->state==0)
                                <div class="d-flex align-items-center ml-5">
                                  <span class="status-icon bg-info"></span>
                                  <small class="text-muted"><b>Pending</b></small>
                                </div>
                              @elseif($game->players->where('user_id',\Auth::user()->id)->first()->state==1)
                                <div class="d-flex align-items-center ml-5">
                                  <span class="status-icon bg-success"></span>
                                  <small class="text-muted"><b>You are attending</b></small>
                                </div>
                              @elseif($game->players->where('user_id',\Auth::user()->id)->first()->state==2)
                                <div class="d-flex align-items-center ml-5">
                                  <span class="status-icon bg-danger"></span>
                                  <small class="text-muted"><b>Rejected</b></small>
                                </div>
                              @endif
                            @endif
                          </div>
                        </div>
                      </div>
                    </a>
                @endforeach
              </div>

            </div>


        {{ $games->links() }}


              </div>
            </div>


  </div>


@endsection
