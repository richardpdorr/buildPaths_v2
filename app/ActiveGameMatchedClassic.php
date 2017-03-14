<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveGameMatchedClassic extends Model
{

    protected $table = 'agmc';
    protected $fillable = ['game_id', 'gameLength', 'gameStartTime'];

    public function summoners(){

        return $this->hasMany('App\Summoner');

    }

}
