<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{

  public function game()
  {
        return $this->belongsTo('App\Game');
  }

  public function user()
  {
        return $this->belongsTo('App\User');
  }

}
