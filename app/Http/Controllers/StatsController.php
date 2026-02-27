<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class StatsController extends Controller
{
    public function getStats(Request $request): Response
    {
        $currentSeasonStats = DB::table('team_players')
            ->select([
                'team_players.name AS player_name',
                'team_players.player_id',
                'teams.name AS team_name',
                'seasons.name AS season_name',
                'team_players.goals',
                'team_players.assists',
                'team_players.is_goalie',
                'team_players.shots_against',
                'team_players.goals_against',
                'team_players.games_played',
                'team_players.shutouts',
            ])
            ->join('teams', 'team_players.team_id', '=', 'teams.id')
            ->join('seasons', 'teams.season_id', '=', 'seasons.id')
            ->whereRaw('current_season = 1 AND (team_players.is_goalie <> 1 OR team_players.goals > 0)')
            ->orderByRaw('team_players.goals + team_players.assists DESC')
            ->get();

        return Inertia::render('Stats', ['stats' => $currentSeasonStats]);
    }
}
