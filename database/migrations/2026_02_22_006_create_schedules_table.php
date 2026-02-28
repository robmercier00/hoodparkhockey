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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->references('id')->on('seasons');
            $table->foreignId('home_team')->references('id')->on('teams');
            $table->unsignedInteger('home_team_goals')->default(0);
            $table->foreignId('away_team')->references('id')->on('teams');
            $table->unsignedInteger('away_team_goals')->default(0);
            $table->dateTime('game_date_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
