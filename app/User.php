<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sports()
    {
        return $this->belongsToMany('App\Sport','user_sports');
    }

    public function myGames()
    {
          return $this->hasMany('App\Game');
    }

    public function games()
    {
          return $this->hasMany('App\GamePlayer');
    }

    public function gamesAccepted()
    {
          return $this->hasMany('App\GamePlayer')->where('state',1);
    }

    public function attending()
    {
          return $this->hasMany('App\GamePlayer')->where('state',1);
    }

    public function pending()
    {
          return $this->hasMany('App\GamePlayer')->where('state',0);
    }

    public function requests()
    {
          return $this->hasMany('App\GamePlayer')->where('type',1);
    }

    public function invites()
    {
          return $this->hasMany('App\GamePlayer')->where('type',2);
    }
}
