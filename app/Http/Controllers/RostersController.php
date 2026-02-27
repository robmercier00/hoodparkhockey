<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RostersController extends Controller
{
    public function getRosters(Request $request): Response
    {
        $teamsRosters = DB::table('team_players')
            ->select([
                'team_players.name AS player_name',
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
            ->where('current_season', '=', 1)
            ->get();

        $rosterPlayers = [];

        foreach ($teamsRosters as $player) {
            if (isset($rosterPlayers[$player->season_name])) {
                if (isset($rosterPlayers[$player->season_name][$player->team_name])) {
                    $rosterPlayers[$player->season_name][$player->team_name][] = $player;
                } else {
                    $rosterPlayers[$player->season_name][$player->team_name] = [$player];
                }
            } else {
                if (isset($rosterPlayers[$player->season_name][$player->team_name])) {
                    $rosterPlayers[$player->season_name][$player->team_name][] = $player;
                } else {
                    $rosterPlayers[$player->season_name][$player->team_name] = [$player];
                }
            }
        }

        return Inertia::render('Rosters', ['rosters' => $rosterPlayers]);
    }
}
