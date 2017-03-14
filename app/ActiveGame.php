<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveGame extends Model
{
    protected $table = 'active_games';
    protected $fillable = ['game_id', 'gameType', 'gameMode', 'gameLength', 'gameStartTime'];

    public function summoners(){

        return $this->hasMany('App\Summoner');

    }
}
