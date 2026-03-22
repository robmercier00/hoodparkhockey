<?php

use App\Http\Controllers\PlayersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Route::get('/seasons', [PlayersController::class, 'getSeasons'])->name('seasons.seasons');


Route::get('teamPlayers', function () {
    return Inertia::render('TeamPlayers');
})->middleware(['verified'])->name('teamPlayers');

Route::get('getTeamPlayers', [PlayersController::class, 'getTeamPlayers'])->name('teamPlayers.get-team-players');
Route::post('teamPlayers', [PlayersController::class, 'addUpdateTeamPlayers'])->name('teamPlayers.team-players');
Route::get('player', [PlayersController::class, 'getPlayer'])->name('teamPlayers.player');