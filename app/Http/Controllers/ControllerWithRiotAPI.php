<?php

namespace App\Http\Controllers;

use App\ActiveGame;
use App\Champion;
use App\Summoner;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class ControllerWithRiotAPI extends Controller
{
    public function fetchSummoners($summoners)
    {
        $this->checkForSummonersLocal($summoners);

        $summonerNamesForUrl = (is_array($summoners)) ? implode(',', $summoners) : $summoners;

        if($summonerNamesForUrl){

            $url = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/";
            $url .= rawurlencode($summonerNamesForUrl);
            $url .= "?api_key=";
            $url .= env('RIOT_API_KEY');

            //Check headers before retrieving API response
            $headers = get_headers($url);
            $riot_api_response_codes = Config::get('constants.RIOT_API_RESPONSES');
            $response['headers'] = $riot_api_response_codes[substr($headers[0], 9, 3)];

            //If API sends 200 response, decode the contents of the response, otherwise return false.
            if ($response['headers'] == 'Success') {

                $summoners_arrays = array_values(json_decode(file_get_contents($url), true));

                foreach($summoners_arrays as $summoner_info){
                    //Convert revisionDate from epoch milliseconds, to DateTime.
                    $summoner_info['revisionDate'] = date("Y-m-d H:i:s", substr($summoner_info['revisionDate'], 0, 10));
                    $summoner_info['summoner_id'] = $summoner_info['id'];
                    unset($summoner_info['id']);

                    $summoners_info[] = $summoner_info;
                }

                $response['summoners'] = $summoners_info;

            }
        }else{
            $response['headers'] = 'Success';
        }

        return $response;

        }

    public function fetchLiveGameFromSummonerId($summoner_id){

        $summoners[] = Summoner::where('summoner_id', $summoner_id)->first();
        $response = $status = $summoner_names          = array();

        $url = "https://na.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/NA1/";
        $url .= rawurlencode($summoner_id);
        $url .= "?api_key=";
        $url .= env('RIOT_API_KEY');

        //Check headers before retrieving API response
        $headers = get_headers($url);
        $riot_api_response_codes = Config::get('constants.RIOT_API_RESPONSES');
        $response['headers'] = $riot_api_response_codes[substr($headers[0], 9, 3)];

        //If API sends 200 response, decode the contents of the response, otherwise return false.
        if($response['headers'] == 'Success'){

            $game_array                             = json_decode(file_get_contents($url), true);
            $game_modes                             = Config::get('constants.RIOT_GAME_MODES');
            $game_types                             = Config::get('constants.RIOT_GAME_TYPES');

//            $game_type_for_model                    = ucfirst($game_modes[$game_array['gameMode']]);
//            $game_mode_for_model                    = ucfirst($game_types[$game_array['gameType']]);

//            $name_of_game_model                     = 'App\ActiveGame'.$game_mode_for_model.$game_type_for_model;

            $game_id = $game_array['game_id']       = $game_array['gameId'];
            unset($game_array['id']);


            //Convert revisionDate from epoch milliseconds, to DateTime.
            $game_array['gameLength']               = gmdate("H:i:s", $game_array['gameLength']);
            $game_array['gameStartTime']            = date("Y-m-d H:i:s", substr($game_array['gameStartTime'], 0, 10));


            $live_game = ActiveGame::create($game_array);

            foreach($game_array['participants'] as $key => $obj){

                $players[$obj['summonerName']] = $obj;

            }

            foreach($game_array['participants'] as $participant) {

                    $summoner_names[] = $participant['summonerName'];
            }
                $info_response = $this->fetchSummoners($summoner_names);

                //Create Summoner model from summonerArray.
                if(!empty($info_response['summoners']))
                {
                    foreach($info_response as $summoner_info) {
                        $summoner = Summoner::create($summoner_info);
                        $active_champion = Champion::create(['champion_id' => $players[$summoner->name]['summonerId']]);
                        $active_champion->activeSummoners()->save($summoner);
                        $summoners[] = $summoner;
                        $status[] = ['status' => 'success'];
                    }
                }else{
                    $status[] = ['status' => $info_response];
                }

                unset($summoner);


            $live_game->summoners()->saveMany($summoners);

            $response['status'] = $status;
            $response['summoners'] = $summoners;
            $response['info_repsonse'] = $info_response;
            $response['livegame'] = $game_array;
            $response['players'] = $players;

            }

            return $response;
    }


    public function isValidSummonerName($summonerName){

        $regex_validation = "/^[0-9\\p{L} _\\.]+$/";
        return (preg_match($regex_validation, $summonerName, $matches));

    }

    public function checkForSummonersLocal(&$summoners){

        if(!is_array($summoners))
        {
            if (count(Summoner::where('name', $summoners)->get())) {
                $summoners = null;
            }
        }else{

            foreach($summoners as $key => $summoner){

                if (count(Summoner::where('name', $summoner)->get())) {
                    unset($summoners[$key]);
                }

            }
        }


        return true;

    }

    public function checkForActiveGameLocal(&$summoners){

        if(!is_array($summoners))
        {
            if (count(Summoner::where('name', $summoners)->get())) {
                $summoners = null;
            }
        }else{

            foreach($summoners as $key => $summoner){

                if (count(Summoner::where('name', $summoner)->get())) {
                    unset($summoners[$key]);
                }

            }
        }


        return true;

    }

    public function populateChampionsIntoLocal(){

        $url = "https://global.api.pvp.net/api/lol/static-data/NA/v1.2/champion?champData=image,passive,stats";
        $url .= "&api_key=";
        $url .= env('RIOT_API_KEY');

        //Check headers before retrieving API response
        $headers = get_headers($url);
        $riot_api_response_codes = Config::get('constants.RIOT_API_RESPONSES');
        $response['headers'] = $riot_api_response_codes[substr($headers[0], 9, 3)];

        //If API sends 200 response, decode the contents of the response, otherwise return false.
        if($response['headers'] == 'Success') {

            $champData                             = json_decode(file_get_contents($url), true)['data'];

            $i=0;
            foreach($champData as $champion){

                if ($i++ > 9) break;
                $champion_local = Champion::create();

                $champion_local->champion_id = $champion['id'];
                $champion_local->name = $champion['name'];
                $champion_local->image_loc = $champion['passive']['image']['full'];

                $champion_local->save();

            }

        }


    }
}
