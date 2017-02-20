<?php

namespace App\Http\Controllers;

use App\Summoner;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class ControllerWithRiotAPI extends Controller
{
    public function getSummonerInfoFromAPI($summonerName)
    {

        $summonerArray = array();

        if ($this->isValidSummonerName($summonerName)) {

            if (!count(Summoner::where('name', $summonerName)->get())) {
                $url = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/";
                $url .= rawurlencode($summonerName);
                $url .= "?api_key=";
                $url .= env('RIOT_API_KEY');

                //Check headers before retrieving API response
                $headers = get_headers($url);
                $riot_api_response_codes = Config::get('constants.RIOT_API_RESPONSES');
                $headers_response = $riot_api_response_codes[substr($headers[0], 9, 3)];

                //If API sends 200 response, decode the contents of the response, otherwise return false.
                if ($headers_response == 'Success') {

                    $summonerArray = array_values(json_decode(file_get_contents($url), true))[0];

                    //Convert revisionDate from epoch milliseconds, to DateTime.
                    $summonerArray['revisionDate'] = date("Y-m-d H:i:s", substr($summonerArray['revisionDate'], 0, 10));
                    $summonerArray['summoner_id'] = $summonerArray['id'];
                    unset($summonerArray['id']);

                }
            }
        }

        return $summonerArray;
    }


    public function isValidSummonerName($summonerName){

        $regex_validation = "/^[0-9\\p{L} _\\.]+$/";
        return (preg_match($regex_validation, $summonerName, $matches));

    }
}
