<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{

  public function index()
  {
      $games = \App\Game::where('date','>=', \Carbon\Carbon::now())->paginate(5);
      return view('games.index',compact('games'));
  }

  public function index_json()
  {
      $games = \App\Game::where('date','>=', \Carbon\Carbon::now())->paginate(10);
      return response()->json($games);
  }

  public function myindex()
  {

      $games = \Auth::user()->myGames()->paginate(5);
      return view('games.index',compact('games'));

  }

  public function attending()
  {

      $games = \Auth::user()->attending()->paginate(5);
      return view('games.index',compact('games'));

  }

  public function pending()
  {

      $games = \Auth::user()->pending()->paginate(5);
      return view('games.index',compact('games'));

  }

  public function accept($id,$player_id)
  {
    $game = \App\Game::find($id);
    $player = \App\GamePlayer::find($player_id);
    if($game AND $player){
      $player->state = 1;
      $player->save();

      $player->user->notify(new \App\Notifications\Accepted(['game_id'=> $game->id]));
      return back()->with('success','Success! You accepted the player successfully');
    }

  }

  public function reject($id,$player_id)
  {
    $game = \App\Game::find($id);
    $player = \App\GamePlayer::find($player_id);
    if($game AND $player){
      $player->state = 2;
      $player->save();

      $player->user->notify(new \App\Notifications\Rejected(['game_id'=> $game->id]));
      return back()->with('success','Success! You rejected the player successfully');
    }

  }

  public function invite($id)
  {
    $game = \App\Game::find($id);
    if($game){
      $players = \App\User::whereDoesntHave("games", function($q) use($game) {
        $q->where('game_id', $game->id);
      })
      ->where('id','<>',\Auth::user()->id)
      ->paginate(9);
      return view('games.invite_players',compact('game','players'));
    }
  }

  public function invite_player($id,$player_id)
  {
    $game = \App\Game::find($id);
    $player = \App\User::find($player_id);
    if($game AND $player){

      $join = new \App\GamePlayer;
      $join->user_id = $player->id;
      $join->game_id = $game->id;
      $join->type = 2;
      $join->save();

      $player->notify(new \App\Notifications\Invite(['game_id'=> $game->id, 'user_id'=> \Auth::user()->id ]));

     return back()->with('success','Success! Your invite was sent successfully');
    }
  }

  public function join($id)
  {

     $game = \App\Game::find($id);

     if($game){

      $join = new \App\GamePlayer;
      $join->user_id = \Auth::user()->id;
      $join->game_id = $game->id;
      $join->type = 1;
      $join->save();

     $game->user->notify(new \App\Notifications\Join(['game_id'=> $game->id, 'user_id'=> \Auth::user()->id ]));

     return back()->with('success','Success! Your request was sent successfully');

     }

  }

  public function show($id)
  {

     $game = \App\Game::find($id);
     return view('games.show',compact('game'));

  }

  public function show_json($id)
  {

     $game = \App\Game::find($id);
     return response()->json($game);

  }

  public function edit($id)
  {

     $game = \App\Game::find($id);
     if(\Auth::user()->myGames->where('id',$id)->first() AND $game){
       $sports = \App\Sport::all();
       return view('games.edit',compact('game','sports'));
     }


  }

  public function create()
  {

     $sports = \App\Sport::all();
     return view('games.create',compact('sports'));

  }

  public function store_message(Request $request,$id)
  {

    $validator = \Validator::make($request->all(), [
        'message' => 'required',
    ]);

    if ($validator->fails()) {
       return back()
                   ->withErrors($validator)
                   ->withInput();
                 }

                 $game = \App\Game::find($id);
                 if($game){

                   $item = new \App\GameMessage;
                   $item->user_id = \Auth::user()->id;
                   $item->game_id = $id;
                   $item->message = $request->message;
                   $item->save();

                   foreach ($game->attending as $user) {
                     if($user->user->id != \Auth::user()->id){
                       $user->user->notify(new \App\Notifications\Message(['game_id'=> $game->id, 'user_id'=> \Auth::user()->id ]));
                      }
                   }

                   return back()->with('success','The message was posted successfully!');
                 }

  }

  public function store(Request $request)
  {

    $validator = \Validator::make($request->all(), [
        'sport' => 'required|integer',
        'players_total' => 'required|integer',
        'players_confirmed' => 'required|integer',
        'local' => 'required',
        'date' => 'required|date',
        'time_start' => 'required|date_format:H:i',
        'time_end' => 'required|date_format:H:i',
        'cost' => 'required',
    ]);

    if ($validator->fails()) {
       return back()
                   ->withErrors($validator)
                   ->withInput();
                 }

        $item = new \App\Game;
        $item->user_id = \Auth::user()->id;
        $item->sport_id = $request->sport;
        $item->num_players = $request->players_total;
        $item->num_players_confirmed = $request->players_confirmed;
        $item->local = $request->local;
        $item->date = \Carbon\Carbon::parse($request->date);
        $item->time_start = $request->time_start;
        $item->time_end = $request->time_end;
        $item->cost = $request->cost;
        if($request->title){
          $item->title = $request->title;
        }
        if($request->description){
          $item->description = $request->description;
        }
        $item->save();
        return redirect('/events/'.$item->id)->with('success','The event was posted successfully!');
  }



  public function update(Request $request,$id)
  {

    $validator = \Validator::make($request->all(), [
        'sport' => 'required|integer',
        'players_total' => 'required|integer',
        'players_confirmed' => 'required|integer',
        'local' => 'required',
        'date' => 'required|date',
        'time_start' => 'required|date_format:H:i',
        'time_end' => 'required|date_format:H:i',
        'cost' => 'required',
    ]);

    if ($validator->fails()) {
       return back()
                   ->withErrors($validator)
                   ->withInput();
                 }

        $item = \App\Game::find($id);

        $item->sport_id = $request->sport;
        $item->num_players = $request->players_total;
        $item->num_players_confirmed = $request->players_confirmed;
        $item->local = $request->local;
        $item->date = \Carbon\Carbon::parse($request->date);
        $item->time_start = $request->time_start;
        $item->time_end = $request->time_end;
        $item->cost = $request->cost;
        if($request->title){
          $item->title = $request->title;
        }
        if($request->description){
          $item->description = $request->description;
        }
        $item->save();
        return redirect('/events/'.$item->id)->with('success','The event was updated successfully!');
  }

}
