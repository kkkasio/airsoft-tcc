<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeagueProfileInvite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_profile_invite', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->boolean('used')->nullable();
            $table->unsignedBigInteger('league_id');
            $table->foreign('league_id')->references('id')->on('leagues');

            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles');


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
        Schema::dropIfExists('league_profile_invite');
    }
}
