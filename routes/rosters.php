<?php

use App\Http\Controllers\RostersController;
use Illuminate\Support\Facades\Route;

Route::get('/rosters', [RostersController::class, 'getRosters'])->name('rosters.rosters');
