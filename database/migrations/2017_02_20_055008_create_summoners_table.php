<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummonersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summoners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('summoner_id')->unsigned();
            $table->integer('profileIconId')->unsigned();
            $table->dateTime('revisionDate');
            $table->integer('summonerLevel')->unsigned();
            $table->integer('active_game_id')->unsigned()->nullable()->index();
            $table->integer('active_champion_id')->unsigned()->nullable()->index();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('summoners');
    }
}
