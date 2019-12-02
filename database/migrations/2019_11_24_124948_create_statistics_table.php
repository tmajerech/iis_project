<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vojenske_skore');
            $table->integer('ekonomicke_skore');
            $table->integer('technologicke_skore');
            $table->integer('socialni_skore');
            $table->integer('doba_preziti');
            $table->bigInteger('match_id')->unsigned()->index();
            $table->bigInteger('user_id')->nullable()->unsigned()->index();
            $table->timestamps();
        });


        Schema::table('statistics', function($table) {
            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
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
        Schema::dropIfExists('statistics');
    }
}
