<?php

use App\Http\Controllers\SeasonsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/seasons', [SeasonsController::class, 'getSeasons'])->name('seasons.seasons');


Route::get('season', function () {
    return Inertia::render('Season');
})->middleware(['verified'])->name('season');

Route::get('single-season', [SeasonsController::class, 'getSeason'])->name('seasons.get-season');

Route::post('season', [SeasonsController::class, 'createOrUpdateSeason'])->name('seasons.create-season');
