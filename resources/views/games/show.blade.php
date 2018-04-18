@extends('layouts.app')

@section('content')

  <div class="container">


    <div class="row">
              <div class="col-md-3">
                <h3 class="page-title mb-5">Event</h3>
                @if(\Auth::user()->id != $game->user->id)
                    @if($game->players->where('user_id',\Auth::user()->id)->count()==0)
                      <a href="/events/{{$game->id}}/join" class="btn btn-primary btn-block mb-6"><i class="fe fe-send"></i> &nbsp; Request to Join</a>
                    @else
                      @if($game->players->where('user_id',\Auth::user()->id)->first())
                        @if($game->players->where('user_id',\Auth::user()->id)->first()->state==0)
                          <div class="btn btn-azure btn-block mb-6 " >Waiting for Response</div>
                        @elseif($game->players->where('user_id',\Auth::user()->id)->first()->state==1)
                            <div class="btn btn-green btn-block mb-6 " >Attending</div>
                          @elseif($game->players->where('user_id',\Auth::user()->id)->first()->state==2)
                              <div class="btn btn-red btn-block mb-6 " >Rejected</div>
                        @endif
                      @endif
                    @endif
                @else
                  <a href="/events/{{$game->id}}/invite" class="btn btn-block btn-primary mb-6"><i class="fe fe-user-plus"></i> &nbsp; Invite Players</a>
                @endif
                <div>

                  <div class="list-group list-group-transparent mb-6" id="myTab" role="tablist">
                      <a class="list-group-item list-group-item-action d-flex align-items-center" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        <span class="icon mr-3">
                          <i class="fe fe-chevron-right"></i></span>
                          <small><b>ATTENDING</b></small>
                          <span class="ml-auto avatar avatar-green">{{$game->attending->count() + $game->num_players_confirmed}}</span>
                      </a>
                      <a class="list-group-item list-group-item-action d-flex align-items-center" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                        <span class="icon mr-3">
                          <i class="fe fe-chevron-right"></i></span>
                          <small><b>REJECTED</b></small>
                          <span class="ml-auto avatar avatar-red">{{$game->players->where('state',2)->count() }}</span>
                      </a>
                      <a class="list-group-item list-group-item-action d-flex align-items-center" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                        <span class="icon mr-3">
                        <i class="fe fe-chevron-right"></i></span>
                        <small><b>PENDING</b></small>
                        <span class="ml-auto avatar avatar-cyan">{{$game->players->where('state',0)->count() }}</span>
                      </a>

                  </div>

                </div>
              </div>
              <div class="col-md-9">

                @if (Session::has('success'))
                	<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <i class="fe fe-check mr-2" aria-hidden="true"></i> {{ Session::get('success') }}
                  </div>
                @endif

                <div class="card">

                  <div class="card-header">
                    <h3 class="card-title"><b>Event Details</b></h3>
                    @if($game->user->id == \Auth::user()->id)
                      <div class="card-options">
                        <a href="/events/{{$game->id}}/edit" class="btn btn-secondary btn-sm ml-2"><i class="fe fe-edit mr-2"></i>Edit</a>
                      </div>
                    @endif
                  </div>
                  <div class="list-group list-group-flush">

                    <div class="list-group-item">
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
                          </div>
                        </div>
                      </div>
                    </div>

              </div>

              <div class="card-body">

                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h4 style="color: #6e7687;" class="card-title">
                      <span class="status-icon bg-success"></span>
                      <b>Players Attending</b>
                    </h4>
                    <ul class="list-group mt-2">

                        <li class="list-group-item">
                          <div class="d-flex justify-content-between align-items-center">
                            <span>
                              <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mt-auto">
                                  <div class="avatar avatar-md mr-3" style="background-image: url({{$game->photo}})"></div>
                                  <div>
                                    <a href="/player/{{$game->user->id}}" class="text-default"><b>{{$game->user->name}}</b></a> + {{$game->num_players_confirmed -1}}
                                    @if($game->user->location)
                                      <small class="d-block text-muted">{{$game->user->location}}</small>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </span>
                            <div >
                              <div class="tag">Owner</div>
                          </div>
                        </div>
                        </li>

                        @foreach ($game->players->where('state',1) as $player)
                          <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                              <span>
                                <div class="d-flex flex-column">
                                  <div class="d-flex align-items-center mt-auto">
                                    <div class="avatar avatar-md mr-3" style="background-image: url({{$player->photo}})"></div>
                                    <div>
                                      <a href="/player/{{$player->user->id}}" class="text-default"><b>{{$player->user->name}}</b></a>
                                      @if($player->user->location)
                                        <small class="d-block text-muted">{{$player->user->location}}</small>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </span>
                              @if(\Auth::user()->id == $game->user->id)
                                <div class="dropdown">
                                  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                     Manage
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/events/{{$game->id}}/player/{{$player->id}}/reject">Reject</a>
                                  </div>
                                </div>
                              @endif
                          </div>
                          </li>
                        @endforeach
                     </ul>
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <h3 style="color: #6e7687;" class="card-title">
                        <span class="status-icon bg-danger"></span>
                        <b>Players Rejected</b></h3>
                      <ul class="list-group mt-2">
                        @if($game->players->where('state',2)->count()==0)
                         <li class="list-group-item">
                          <small class="text-muted">No players rejected</small>
                         </li>
                        @endif
                        @foreach ($game->players->where('state',2) as $player)
                          <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                              <span>
                                <div class="d-flex flex-column">
                                  <div class="d-flex align-items-center mt-auto">
                                    <div class="avatar avatar-md mr-3" style="background-image: url({{$player->photo}})"></div>
                                    <div>
                                      <a href="/player/{{$player->user->id}}" class="text-default"><b>{{$player->user->name}}</b></a>
                                      @if($player->user->location)
                                        <small class="d-block text-muted">{{$player->user->location}}</small>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </span>
                              @if(\Auth::user()->id == $game->user->id)
                                <div class="dropdown">
                                  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                     Manage
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/events/{{$game->id}}/player/{{$player->id}}/accept">Accept</a>
                                  </div>
                              </div>
                              @endif
                            </div>
                          </li>
                        @endforeach
                     </ul>
                  </div>
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <h3 style="color: #6e7687;" class="card-title">
                      <span class="status-icon bg-teal"></span>
                      <b>Players Pending</b></h3>
                    <ul class="list-group mt-2">
                        @if($game->players->where('state',0)->count()==0)
                         <li class="list-group-item">
                          <small class="text-muted">No players pending</small>
                         </li>
                        @endif
                        @foreach ($game->players->where('state',0) as $player)
                          <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                              <span>
                                <div class="d-flex flex-column">
                                  <div class="d-flex align-items-center mt-auto">
                                    <div class="avatar avatar-md mr-3" style="background-image: url({{$player->photo}})"></div>
                                    <div>
                                      <a href="/player/{{$player->user->id}}" class="text-default"><b>{{$player->user->name}}</b></a>
                                      @if($player->user->location)
                                        <small class="d-block text-muted">{{$player->user->location}}</small>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </span>
                              @if(\Auth::user()->id == $game->user->id)
                                  <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                       Manage
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="/events/{{$game->id}}/player/{{$player->id}}/accept">Accept</a>
                                      <a class="dropdown-item" href="/events/{{$game->id}}/player/{{$player->id}}/reject">Reject</a>
                                    </div>
                                </div>
                              @endif
                          </div>
                          </li>
                        @endforeach
                     </ul>
                  </div>
                </div>
              </div>
              @if($game->players->where('user_id',\Auth::user()->id)->where('state',1)->count()>0 OR $game->user->id == \Auth::user()->id)
              <div class="card-footer">
                <h4 class="card-title"><i class="fe fe-message-circle mr-2"></i><b>Messages</b></h4>
                <div class="card">
                  <div class="card-header p-2">
                    <form class="w-100" action="/events/{{$game->id}}/message/send" method="post">
                      {{ csrf_field() }}
                      <div class="input-group">
                          <input type="text" name="message" class="form-control" placeholder="Message">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">
                              <i class="fe fe-send"></i>
                            </button>
                          </div>
                        </div>
                    </form>
                  </div>
                  <ul class="list-group card-list-group">
                    @if($game->messages->count()==0)
                      <li class="list-group-item">
                        <small>No messages yet</small>
                      </li>
                    @endif
                    @foreach ($game->messages as $message)
                      <li class="list-group-item py-5">
                        <div class="media">
                          <div class="media-object avatar avatar-md mr-4" style="background-image: url({{$message->user->photo}})"></div>
                          <div class="media-body">
                            <div class="media-heading">
                              <small class="float-right text-muted">{{\Carbon\Carbon::parse($message->created_at)->diffforhumans()}}</small>
                              <h5>{{$message->user->name}}</h5>
                            </div>
                            <div>
                              {{$message->message}}
                            </div>
                          </div>
                        </div>
                      </li>
                    @endforeach

                  </ul>
                </div>
              </div>
              @endif

            </div>

          </div>
        </div>




  </div>

@endsection
