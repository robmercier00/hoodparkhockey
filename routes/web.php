<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/media', function () {
    return Inertia::render('Media');
})->name('media');

Route::get('/rules', function () {
    return Inertia::render('Rules');
})->name('rules');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/utilities.php';
require __DIR__.'/standings.php';
require __DIR__.'/schedule.php';
require __DIR__.'/rosters.php';
require __DIR__.'/stats.php';
require __DIR__.'/records.php';