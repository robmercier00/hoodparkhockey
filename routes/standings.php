<?php

use App\Http\Controllers\StandingsController;
use Illuminate\Support\Facades\Route;

Route::get('/standings', [StandingsController::class, 'getStandings'])->name('standings.standings');
