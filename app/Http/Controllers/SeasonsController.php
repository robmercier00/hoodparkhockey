<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SeasonsController extends Controller
{
    public function getSeasons(Request $request): Collection
    {
        $allSeasons = DB::table('seasons')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($allSeasons as $season) {
            $season->start_date = date('m/d/Y', strtotime($season->start_date));
            $season->end_date = date('m/d/Y', strtotime($season->end_date));
        }

        return $allSeasons;
    }

    public function createSeason(Request $request): int|string
    {
        $seasonData = $request->json()->all();
        $newSeason = [
            "name" => $seasonData['seasonName'],
            "start_date" => $seasonData['startDate'],
            "end_date" => $seasonData['endDate'],
            "current_season" => isset($seasonData['currentSeason']) ? 1 : 0
        ];

        try {
            // Insert the user data and retrieve the last inserted ID
            $lastInsertedId = DB::table('seasons')->insertGetId($newSeason);
        } catch (Exception $e) {
            return "Exception when inserting new season: " . $e->getMessage();
        }

        $numberOfTeams = $seasonData['numTeams'];

        // Process the number of teams
        for ($i = 0; $i < (int) $numberOfTeams; $i++) {
            $newTeam = [
                "name" => $seasonData['teamName' . $i + 1],
                "season_id" => $lastInsertedId,
                "color" => $seasonData['teamColor' . $i + 1]
            ];
            // insert team with name, color, and season_id

            try {
                $newTeamInserted = DB::table("teams")->insertGetId($newTeam);
            } catch (Exception $e) {
                return "Exception when inserting new team: " . $e->getMessage();
            }
        }

        return $lastInsertedId;
    }
}
