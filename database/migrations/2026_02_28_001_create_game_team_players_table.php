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
        Schema::create('game_team_players', function (Blueprint $table) {
            $table->foreignId('game_id')->references('id')->on('games');
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->foreignId('player_id')->references('id')->on('players');
            $table->text('player_name')->nullable()->default(null);
            $table->unsignedTinyInteger('is_goalie')->default(0);
            $table->unsignedInteger('goals')->default(0);
            $table->unsignedInteger('assists')->default(0);
            $table->unsignedInteger('shots_against')->nullable()->default(null);
            $table->unsignedInteger('goals_against')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_team_players');
    }
};
