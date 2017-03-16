<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    protected $table = 'summoners';
    protected $fillable = ['name', 'summoner_id', 'profileIconId', 'revisionDate', 'summonerLevel'];

    public function activeGame(){

        return $this->belongsTo('App\ActiveGame');

    }

    public function activeChampion(){

        return $this->belongsTo('App\Champion', 'champion_id', 'active_champion_id');

    }

}
