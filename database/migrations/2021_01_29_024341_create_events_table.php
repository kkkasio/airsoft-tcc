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
            $table->dateTime('startdate');
            $table->dateTime('enddate');
            $table->string('file');
            $table->integer('players');
            $table->text('about');
            $table->enum('type',['Reunião','Jogo']);
            $table->enum('status',['Aberto','Encerrado','Planejado','Finalizado']);

            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');

            $table->unsignedBigInteger('league_id')->nullable();
            $table->foreign('league_id')->references('id')->on('leagues');

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
