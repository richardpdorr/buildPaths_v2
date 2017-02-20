<?php

namespace App\Http\Controllers;

use App\Summoner;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class SummonerController extends ControllerWithRiotAPI
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

        /*
         * Summoner name is received from input,
         * if info already exists locally, create Summoner Model using it,
         * otherwise create and store new summoner from Riot API response.
         */
        $summonerName = $request->name;

        $summonerArray = $this->getSummonerInfoFromAPI($summonerName);

        //Create Summoner model from summonerArray.
        if(!empty($summonerArray)) Summoner::create($summonerArray);

        return redirect('/summoner/'.$summonerName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($summonerName)
    {
        $summoner = Summoner::where('name', $summonerName)->get();

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

    public function isValidSummonerName($summonerName){

        $regex_validation = "/^[0-9\\p{L} _\\.]+$/";
        return (preg_match($regex_validation, $summonerName, $matches));

    }
}
