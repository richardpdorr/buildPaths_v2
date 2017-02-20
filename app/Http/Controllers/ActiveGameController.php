<?php

namespace App\Http\Controllers;

use App\ActiveGameMatchedClassic;
use App\Summoner;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;

use GuzzleHttp\Client;

class ActiveGameController extends ControllerWithRiotAPI
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id = $request->id;
        $game_id = 0;

        $url = "https://na.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/NA1/";
        $url .= rawurlencode($id);
        $url .= "?api_key=";
        $url .= env('RIOT_API_KEY');



        //Check headers before retrieving API response
        $headers = get_headers($url);
        $riot_api_response_codes = Config::get('constants.RIOT_API_RESPONSES');
        $headers_response = $riot_api_response_codes[substr($headers[0], 9, 3)];

        //If API sends 200 response, decode the contents of the response, otherwise return false.
        if($headers_response == 'Success'){


            $gameArray = json_decode(file_get_contents($url), true);

            $gameModes = Config::get('constants.RIOT_GAME_MODES');
            $gameTypes = Config::get('constants.RIOT_GAME_TYPES');


            $gameType = $gameModes[$gameArray['gameMode']];
            $gameMode = $gameTypes[$gameArray['gameType']];


            $namespaceModel = 'App\ActiveGame'.$gameMode.$gameType;


            $game_id = $gameArray['game_id'] = $gameArray['gameId'];
            unset($gameArray['id']);
            //Convert revisionDate from epoch milliseconds, to DateTime.
            $gameArray['gameLength'] = gmdate("H:i:s", $gameArray['gameLength']);
            $gameArray['gameStartTime'] = date("Y-m-d H:i:s", substr($gameArray['gameStartTime'], 0, 10));

            $namespaceModel::create($gameArray);

            foreach($gameArray['participants'] as $participant){

                $summonerName = $participant['summonerName'];
                $summonerArray = $this->getSummonerInfoFromAPI($summonerName);

                //Create Summoner model from summonerArray.
                if(!empty($summonerArray)) Summoner::create($summonerArray);
                unset($summonerArray);

            }

            return 1
                ;

        }

        //return $namespaceModel::gameInfo();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($game_id)
    {

        $summoner = Summoner::where('game_id', $game_id)->get();

        return (count($summoner)) ? view('summoners.info')->with('summoner', $summoner) : view('summoners.info')->with('summoner', '');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
