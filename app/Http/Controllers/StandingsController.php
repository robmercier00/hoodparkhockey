<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class StandingsController extends Controller
{
    public function getStandings(Request $request): Response
    {
        $seasonTeams = DB::table('teams')
            ->select([
                'teams.name',
                'teams.season_id',
                'seasons.name as season_name',
                'teams.win',
                'teams.loss',
                'teams.tie',
                'teams.goals_for',
                'teams.goals_against',
            ])
            ->join('seasons', 'teams.season_id', '=', 'seasons.id')
            ->where('seasons.current_season', '=', 1)
            ->orderBy('points', 'desc')
            ->orderBy('win', 'desc')
            ->orderBy('goals_for', 'desc')
            ->get();

        $standings = [];

        foreach ($seasonTeams as $team) {
            $team->points = (2 * $team->win) + $team->tie;

            if (isset($standings[$team->season_name])) {
                $standings[$team->season_name][] = $team;
            } else {
                $standings[$team->season_name] = [$team];
            }
        }

        return Inertia::render('Standings', ['standings' => $standings]);
    }
}
