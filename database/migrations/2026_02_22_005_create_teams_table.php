<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('season_id')->references('id')->on('seasons');
            $table->unsignedInteger('win')->default(0);
            $table->unsignedInteger('loss')->default(0);
            $table->unsignedInteger('tie')->default(0);
            $table->unsignedInteger('points')->default(0);
        });

        Schema::create('team_players', function (Blueprint $table) {
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->foreignId('player_id')->references('id')->on('players');
            $table->unsignedInteger('goals')->default(0);
            $table->unsignedInteger('assists')->default(0);
            $table->boolean('is_goalie')->default(false);
            $table->unsignedInteger('shots_against')->nullable();
            $table->unsignedInteger('goals_against')->nullable();
            $table->unsignedInteger('games_played')->nullable();
            $table->unsignedInteger('shutouts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_players');
    }
};
