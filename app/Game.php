<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

  public function user()
  {
        return $this->belongsTo('App\User');
  }

  public function sport()
  {
        return $this->belongsTo('App\Sport');
  }

  public function players()
  {
        return $this->hasMany('App\GamePlayer');
  }

  public function messages()
  {
        return $this->hasMany('App\GameMessage');
  }

  public function attending()
  {
        return $this->hasMany('App\GamePlayer')->where('state',1);
  }

}
