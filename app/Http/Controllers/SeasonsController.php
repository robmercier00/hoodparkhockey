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

    public function getSeason(Request $request): Collection
    {
        if ($request->id > 0) {
            $seasonData = DB::table('seasons')
                ->select([
                    'id',
                    'name AS seasonName',
                    'start_date AS startDate',
                    'end_date AS endDate',
                    'current_season as currentSeason',
                ])
                ->addSelect([
                    'numTeams' => DB::table('teams')
                        ->selectRaw('COUNT(1)')
                        ->whereColumn('teams.season_id', 'seasons.id')
                ])
                ->where('id', $request->id)
                ->get();

            if ($seasonData[0]->numTeams > 0) {
                $seasonTeams = DB::table('teams')
                    ->select(['id', 'name', 'color'])
                    ->where('season_id', $request->id)
                    ->get();

                foreach ($seasonTeams as $key => $team) {
                    $teamNumber = $key + 1;
                    $teamIdIdentifier = 'teamId' . $teamNumber;
                    $teamNameIdentifier = 'teamName' . $teamNumber;
                    $teamColorIdentifier = 'teamColor' . $teamNumber;
                    $seasonData[0]->$teamNameIdentifier = $team->name;
                    $seasonData[0]->$teamColorIdentifier = $team->color;
                    $seasonData[0]->$teamIdIdentifier = $team->id;
                }
            }

            return $seasonData;
        }
    }

    public function createOrUpdateSeason(Request $request): int|string
    {
        $seasonData = $request->json()->all();

        $seasonName = $seasonData['seasonName'];
        $seasonStartDate = $seasonData['startDate'];
        $seasonEndDate = $seasonData['endDate'];
        $seasonCurrentSeason = isset($seasonData['currentSeason']) ? 1 : 0;

        try {
            $id = DB::selectOne(
                "INSERT INTO seasons (name, start_date, end_date, current_season)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    id = LAST_INSERT_ID(id),
                    start_date = VALUES(start_date),
                    end_date = VALUES(end_date),
                    current_season = VALUES(current_season)",
                [$seasonName, $seasonStartDate, $seasonEndDate, $seasonCurrentSeason]
            );

            // Get the last insert ID (works for both insert and update)
            $lastId = DB::getPdo()->lastInsertId();
        } catch (Exception $e) {
            return "Exception when inserting new season: " . $e->getMessage();
        }

        $numberOfTeams = $seasonData['numTeams'];

        // Process the number of teams
        for ($i = 0; $i < (int) $numberOfTeams; $i++) {
            $teamId = $seasonData['teamId' . $i + 1];
            $teamName = $seasonData['teamName' . $i + 1];
            $teamColor = $seasonData['teamColor' . $i + 1];

            // insert team with name, color, and season_id

            try {
                $newTeamInserted = DB::selectOne(
                    "INSERT INTO teams (id, name, season_id, color)
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        name = VALUES(name),
                        color = VALUES (color)",
                    [$teamId, $teamName, $lastId, $teamColor]
                );
            } catch (Exception $e) {
                return "Exception when inserting new team: " . $e->getMessage();
            }
        }

        return $lastId;
    }
}
