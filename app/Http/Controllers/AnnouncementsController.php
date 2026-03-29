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
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getLatestAnnouncement(Request $request): Collection
    {
        return DB::table('announcements')
            ->limit(1)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOneAnnouncement(Request $request): Collection
    {
        $announcementId = $request->announcement_id;

        return DB::table('announcements')
            ->where('id', '=', $announcementId)
            ->get();
    }

    public function addOrUpdateAnnouncement(Request $request): ?string
    {
        $announcementRequest = $request->json()->all();

        if ($announcementRequest['announcement_id'] > 0) {
            // update existing announcement
            try {
                DB::selectOne(
                    'UPDATE announcements SET
                        created_at = NOW(),
                        announcement = ?
                        WHERE id = ?',
                    [
                        $announcementRequest['announcement'],
                        $announcementRequest['announcement_id'],
                    ]
                );
            } catch (\Exception $e) {
                return 'Error updating announcement: '.$e->getMessage();
            }
        } elseif ($announcementRequest['announcement_id'] == 0) {
            try {
                DB::selectOne(
                    'INSERT INTO announcements (created_at, announcement)
                    VALUES (NOW(), ?)',
                    [
                        $announcementRequest['announcement'],
                    ]
                );
            } catch (\Exception $e) {
                return 'Error inserting announcement: '.$e->getMessage();
            }
        }

        return 'Announcement saved successfully. Press Esc to continue.';
    }
}
