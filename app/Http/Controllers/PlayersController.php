<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlayersController
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getTeamPlayers(Request $request): Collection
    {
        if ($request->seasonId > 0 && $request->teamId > 0) {
            $seasonTeam = DB::table('teams')
                ->select(['id', 'name'])
                ->addSelect([
                    'seasonName' => DB::table('seasons')
                        ->select(['name'])
                        ->whereColumn('teams.season_id', 'seasons.id'),
                ])
                ->where('season_id', $request->seasonId)
                ->limit(1)
                ->offset((int) $request->teamId - 1)
                ->get();

            $teamPlayers = DB::table('team_players')
                ->selectRaw('team_players.player_id AS id, team_players.name AS name, team_players.goals, '.
                    'team_players.assists, team_players.is_goalie, team_players.shots_against, '.
                    'team_players.goals_against, team_players.games_played, team_players.shutouts')
                ->join('teams as tt', 'team_players.team_id', '=', 'tt.id')
                ->where('team_players.team_id', $seasonTeam[0]->id)
                ->get();

            $seasonTeam[0]->teamPlayers = $teamPlayers;

            return $seasonTeam;
        }
    }

    public function getPlayer(Request $request): array
    {
        $playerName = $request->playerName;

        $player = DB::table('players')
            ->where('name', 'LIKE', "%$playerName%")
            ->get();

        return $player->values()->all();
    }

    public function addUpdateTeamPlayers(Request $request): string
    {
        $teamPlayerData = $request->json()->all();
        $teamId = $teamPlayerData['team_id'];

        // first remove all existing players in case we've deleted some
        DB::table('team_players')
            ->where('team_id', $teamId)
            ->delete();

        foreach ($teamPlayerData as $playerIndex => $data) {
            if ($playerIndex !== 'team_id') {
                $parsedPlayerIndex = explode('-', $playerIndex);

                $playerId = $data;
                $goalieId = null;

                // player is goalie; generally true if exists
                if (isset($parsedPlayerIndex[1]) && $parsedPlayerIndex[1] == 'is_goalie') {
                    $goalie = explode('_', $parsedPlayerIndex[0]);
                    $goalieIndex = $goalie[1];
                    $goalieId = $teamPlayerData['player_'.$goalieIndex];
                    $playerId = $goalieId;
                }

                $insertParams = [
                    'team_id' => (int) $teamId,
                    'player_id' => (int) $playerId,
                    'is_goalie' => (int) ($goalieId == $playerId),
                ];

                try {
                    DB::selectOne(
                        'INSERT INTO team_players (team_id, player_id, name, is_goalie)
                        VALUES (?, ?, (SELECT name FROM players WHERE id = ? LIMIT 1), ?)
                        ON DUPLICATE KEY UPDATE
                            is_goalie = ?',
                        [
                            $insertParams['team_id'],
                            $insertParams['player_id'],
                            $insertParams['player_id'],
                            $insertParams['is_goalie'],
                            $insertParams['is_goalie'],
                        ]
                    );
                } catch (\Exception $e) {
                    return 'Error inserting team_players: '.$e->getMessage();
                }
            }
        }

        return 'Team players saved successfully. Press Esc to continue.';
    }
}
