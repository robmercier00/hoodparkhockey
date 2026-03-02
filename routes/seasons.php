<?php

use App\Http\Controllers\SeasonsController;
use Illuminate\Support\Facades\Route;

Route::get('/seasons', [SeasonsController::class, 'getSeasons'])->name('seasons.seasons');
