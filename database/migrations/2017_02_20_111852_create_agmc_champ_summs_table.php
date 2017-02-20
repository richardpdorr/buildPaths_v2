<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgmcChampSummsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agmc_champions_summoners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->integer('champion_id')->unsigned();
            $table->integer('summoner_id')->unsigned();

            $table->foreign('game_id')->references('game_id')->on('agmc')->onDelete('cascade');
            $table->foreign('champion_id')->references('champion_id')->on('champions')->onDelete('cascade');
            $table->foreign('summoner_id')->references('summoner_id')->on('summoners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agmc_champions_summoners');
    }
}
