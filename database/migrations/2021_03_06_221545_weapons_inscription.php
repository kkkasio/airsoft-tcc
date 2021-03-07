<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WeaponsInscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapon_inscription', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('inscription_id');
            $table->foreign('inscription_id')->references('id')->on('profile_event')->onDelete('CASCADE');
            $table->unsignedBigInteger('weapon_id')->nullable();
            $table->foreign('weapon_id')->references('id')->on('weapons');
            $table->integer('fps');
            $table->string('note')->nullable();

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
        //
    }
}
