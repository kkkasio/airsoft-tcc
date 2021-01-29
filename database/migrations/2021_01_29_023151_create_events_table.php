<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->integer('players');
            $table->string('about');
            $table->enum('type',['Reunião','Jogo']);
            $table->enum('status',['Aberto','Fechado','Planejado']);


            $table->unsignedBigInteger('league_id');
            $table->foreign('league_id')->references('id')->on('leagues');

            $table->unsignedBigInteger('team_id')->nullable(); // se nulo quem faz o jogo é a ADM
            $table->foreign('team_id')->references('id')->on('teams');

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
        Schema::dropIfExists('events');
    }
}
