<?php

use App\Http\Controllers\RecordsController;
use Illuminate\Support\Facades\Route;

Route::get('/records', [RecordsController::class, 'getRecords'])->name('records.records');
