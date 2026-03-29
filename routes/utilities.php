<?php

use App\Http\Controllers\AnnouncementsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('announcements', [AnnouncementsController::class, 'getAnnouncements'])->name('announcements.get-announcements');
Route::post('announcement', [AnnouncementsController::class, 'addOrUpdateAnnouncement'])->name('announcements.create');
Route::get('latest-announcements', [AnnouncementsController::class, 'getLatestAnnouncement'])->name('announcements.get-latest');
Route::get('single-announcement', [AnnouncementsController::class, 'getOneAnnouncement'])->name('announcements.get-one');