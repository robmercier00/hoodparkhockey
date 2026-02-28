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
        Schema::create('all_time_records', function (Blueprint $table) {
            $table->text('record_name');
            $table->text('player_team_name');
            $table->text('record_text');
            $table->text('record_accomplished');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_time_records');
    }
};
