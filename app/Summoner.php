<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    protected $table = 'summoners';
    protected $fillable = ['name', 'summoner_id', 'profileIconId', 'revisionDate', 'summonerLevel'];

}
