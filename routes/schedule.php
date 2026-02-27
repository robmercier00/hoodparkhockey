<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/schedule', [ScheduleController::class, 'getSchedule'])->name('schedule.schedule');

Route::get('latest-schedule', [ScheduleController::class, 'getLatestSchedule'])->name('schedule.get-latest');
