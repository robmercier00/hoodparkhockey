<?php

use App\Http\Controllers\AnnouncementsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('announcements', [AnnouncementsController::class, 'getAnnouncements'])->name('announcements.get-announcements');

Route::get('latest-announcements', [AnnouncementsController::class, 'getLatestAnnouncement'])->name('announcements.get-latest');
