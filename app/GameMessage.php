<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameMessage extends Model
{

  protected $table='game_message';

  public function user()
  {
        return $this->belongsTo('App\User');
  }

}
