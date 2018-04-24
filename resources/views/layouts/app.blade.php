<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>MatchFind</title>
  <meta name="description" content="Find sport events to attend, and players for your event">
  <meta name="robots" content="index,follow">
  <meta name="googlebot" content="index,follow">

  <meta property="og:url" content="http://matchfind.xyz">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Matchfind">
  <meta property="og:image" content="http://matchfind.xyz/images/1.png">
  <meta property="og:description" content="Find sport events to attend, and players for your event">
  <meta property="og:site_name" content="Matchfind">

  <meta name="twitter:card" content="summary">
  <meta name="twitter:creator" content="@diogopalhais">
  <meta name="twitter:url" content="http://matchfind.xyz">
  <meta name="twitter:title" content="Matchfind">
  <meta name="twitter:description" content="Find sport events to attend, and players for your event">
  <meta name="twitter:image" content="http://matchfind.xyz/images/1.png">

  <meta itemprop="name" content="Matchfind">
  <meta itemprop="description" content="Find sport events to attend, and players for your event">
  <meta itemprop="image" content="http://matchfind.xyz/images/1.png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/dashboard.css" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">

    <script src="https://use.fontawesome.com/5724838085.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="/js/jquery.inputmask.bundle.js"></script>
    <link href="/css/datepicker.css" rel="stylesheet" type="text/css">
    <script src="/js/datepicker.js"></script>
    <script src="/js/datepicker.en.js"></script>
</head>
<body>
    <div id="app">

    <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="/events">
                <span style="background:#3742fa" class="avatar"></span>
                 &nbsp; match<span class="text-muted">find</span>
                 <sup><small class="text-muted"> beta</small></sup>
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-flex">
                  <a class="nav-link icon" data-toggle="dropdown">
                    <i class="fe fe-bell"></i>
                    @if(\Auth::user()->unreadNotifications->count()>0)
                      <span class="nav-unread"></span>
                    @endif
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    @if(\Auth::user()->unreadNotifications->count()==0)
                      <span class="dropdown-item d-flex">
                        <div>
                          <div class="small text-muted">No unread notifications</div>
                        </div>
                      </span>
                    @endif
                    @foreach (\Auth::user()->unreadNotifications as $notification)
                      @if($notification->type == 'App\Notifications\Join')
                        <a href="/events/{{\App\Game::find($notification->data['game_id'])->id}}" class="dropdown-item d-flex">
                          <span class="avatar mr-3 align-self-center" style="background-image: url({{\App\User::find($notification->data['user_id'])->photo}})"></span>
                          <div>
                            <strong>{{\App\User::find($notification->data['user_id'])->name}}</strong> sent you a request to join your event
                            <div class="small text-muted">{{\Carbon\Carbon::parse($notification->created_at)->diffforhumans()}}</div>
                          </div>
                        </a>
                      @elseif($notification->type == 'App\Notifications\Message')
                        <a href="/events/{{\App\Game::find($notification->data['game_id'])->id}}" class="dropdown-item d-flex">
                          <span class="avatar mr-3 align-self-center" style="background-image: url({{\App\User::find($notification->data['user_id'])->photo}})"></span>
                          <div>
                            <strong>{{\App\User::find($notification->data['user_id'])->name}}</strong> posted a new message in the event
                            <div class="small text-muted">{{\Carbon\Carbon::parse($notification->created_at)->diffforhumans()}}</div>
                          </div>
                        </a>
                      @elseif($notification->type == 'App\Notifications\Invite')
                        <a href="/invites" class="dropdown-item d-flex">
                          <span class="avatar mr-3 align-self-center" style="background-image: url({{\App\User::find($notification->data['user_id'])->photo}})"></span>
                          <div>
                            <strong>{{\App\User::find($notification->data['user_id'])->name}}</strong> invited you to join the event
                            <div class="small text-muted">{{\Carbon\Carbon::parse($notification->created_at)->diffforhumans()}}</div>
                          </div>
                        </a>
                      @elseif($notification->type == 'App\Notifications\Accepted')
                        <a href="/events/{{\App\Game::find($notification->data['game_id'])->id}}" class="dropdown-item d-flex">
                          <span class="avatar mr-3 align-self-center" style="background-image: url({{\App\Game::find($notification->data['game_id'])->user->photo}})"></span>
                          <div>
                            <strong>{{\App\Game::find($notification->data['game_id'])->user->name}}</strong> accepted your request to join the event
                            <div class="small text-muted">{{\Carbon\Carbon::parse($notification->created_at)->diffforhumans()}}</div>
                          </div>
                        </a>
                      @elseif($notification->type == 'App\Notifications\Rejected')
                        <a href="/events/{{\App\Game::find($notification->data['game_id'])->id}}" class="dropdown-item d-flex">
                          <span class="avatar mr-3 align-self-center" style="background-image: url({{\App\Game::find($notification->data['game_id'])->user->photo}})"></span>
                          <div>
                            <strong>{{\App\Game::find($notification->data['game_id'])->user->name}}</strong> rejected your request to join the event
                            <div class="small text-muted">{{\Carbon\Carbon::parse($notification->created_at)->diffforhumans()}}</div>
                          </div>
                        </a>
                      @endif
                    @endforeach
                    @if(\Auth::user()->unreadNotifications->count()>0)
                    <div class="dropdown-divider"></div>
                    <a href="/markallasread" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
                    @endif
                  </div>
                </div>
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url({{\Auth::user()->photo}})"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{ Auth::user()->name }}</span>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href=/profile>
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <a onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();" class="dropdown-item" href="{{ route('logout') }}">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="header d-flex p-0">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0  flex-row">
                  <li class="nav-item">
                    <a href="/events" class="nav-link active">
                      <i class="fe fe-grid"></i>
                      Events &nbsp;
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/requests" class="nav-link">
                      <i class="fe fe-arrow-up"></i>
                      Requests &nbsp;
                      <span class="tag tag-rounded">{{\Auth::user()->requests->count()}}</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/invites" class="nav-link">
                      <i class="fe fe-arrow-down"></i>
                      Invites &nbsp;
                      <span class="tag tag-rounded">{{\Auth::user()->invites->count()}}</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>


    <div class="mt-5"></div>

        @yield('content')
    </div>


    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118140698-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-118140698-1');
</script>


</body>
</html>
