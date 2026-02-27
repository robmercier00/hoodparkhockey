<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class AnnouncementsController extends Controller
{
    public function getAnnouncements(Request $request): Collection
    {
        return DB::table('announcements')
            ->get();
    }

    public function getLatestAnnouncement(Request $request): Collection
    {
        return DB::table('announcements')
            ->limit(1)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
