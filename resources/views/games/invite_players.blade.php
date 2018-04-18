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
        <h3 class="card-title"><b>Invite Players</b></h3>
      </div>

    <div class="list-group list-group-flush">
      @if($players->count()==0)
        <li class="list-group-item">
          <small class="text-muted">
            No players available for now
          </small>
        </li>
      @endif
    @foreach ($players as $player)

          <div class="list-group-item">

            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex flex-column">
                <div class="d-flex align-items-center mt-auto">
                  <div class="avatar avatar-md mr-3" style="background-image: url({{$player->photo}})"></div>
                  <div>
                    <a href="/player/{{$player->id}}" class="text-default"><b>{{$player->name}}</b></a>
                    <small class="d-block text-muted">{{$player->location}}</small>
                    <div class="mt-1">
                    @foreach ($player->sports as $sport)
                      <span class="tag">{{$sport->name}}</span>
                    @endforeach
                    </div>
                  </div>
                </div>
              </div>
              <a href="/events/{{$game->id}}/invite/{{$player->id}}" class="btn btn-primary">Invite</a>
            </div>
          </div>

    @endforeach
    </div>

    {{ $players->links() }}

  </div>


@endsection
