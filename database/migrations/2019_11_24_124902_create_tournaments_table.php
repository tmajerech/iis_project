<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('cena');
            $table->integer('pocet_teamu');
            $table->integer('pocet_hracu');
            $table->string('typ_hracu')->nullable(); ;
            $table->integer('poplatek');
            $table->string('vlastnost_teamu')->nullable();    
            $table->bigInteger('user_id')->unsigned()->index();
            $table->timestamps();
        });


        Schema::table('tournaments', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
