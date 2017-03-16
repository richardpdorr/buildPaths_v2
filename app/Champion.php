<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    //
    protected $table = "champions";

    protected $fillable = [

        'champion_id'

    ];

    public function activeSummoners(){

        return $this->hasMany('App\Summoner', 'active_champion_id', 'champion_id');

    }

}
