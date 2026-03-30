<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{
    public function getSchedule(Request $request): Response
    {
        $schedules = DB::table('schedules')
            ->selectRaw("DATE_FORMAT(schedules.game_date_time, '%Y-%m-%d %H:%i') AS game_date_time, ht.name AS home_team, at.name AS away_team")
            ->join('teams as ht', 'schedules.home_team', '=', 'ht.id')
            ->join('teams as at', 'schedules.away_team', '=', 'at.id')
            ->join('seasons', 'schedules.season_id', '=', 'seasons.id')
            ->where('current_season', '=', 1)
            ->get();

        $processedSchedules = [];

        foreach ($schedules as $schedule) {
            $gameDay = date('m/d/Y', strtotime($schedule->game_date_time));
            $schedule->game_time = date('g:i A', strtotime($schedule->game_date_time));

            if (isset($processedSchedules[$gameDay])) {
                $processedSchedules[$gameDay][] = $schedule;
            } else {
                $processedSchedules[$gameDay] = [$schedule];
            }
        }

        return Inertia::render('Schedule', ['schedule' => $processedSchedules]);
    }

    public function getLatestSchedule(): Collection
    {
        $schedules = DB::table('schedules')
            ->selectRaw("DATE_FORMAT(schedules.game_date_time, '%Y-%m-%d %H:%i') AS game_date_time, ht.name AS home_team, at.name AS away_team")
            ->join('teams as ht', 'schedules.home_team', '=', 'ht.id')
            ->join('teams as at', 'schedules.away_team', '=', 'at.id')
            ->whereRaw("DATE_FORMAT(game_date_time, '%Y-%m-%d') = (".
    	        "SELECT MAX(DATE_FORMAT(game_date_time, '%Y-%m-%d')) ".
                'FROM schedules WHERE game_date_time < ('.
		        'CURDATE() + INTERVAL ((10 - DAYOFWEEK(CURDATE())) % 7) DAY) OR '.
                'game_date_time < (CURDATE() + INTERVAL ((7 - DAYOFWEEK(CURDATE())) % 7) DAY))')
            ->orderBy('game_date_time', 'asc')
            ->get();

        foreach ($schedules as $schedule) {
            $schedule->game_day = date('m/d/Y', strtotime($schedule->game_date_time));
            $schedule->game_time = date('g:i A', strtotime($schedule->game_date_time));
        }

        return $schedules;
    }

    public function createSchedule(Request $request): ?string
    {
        $scheduleParams = $request->json()->all();
        $scheduleLength = $scheduleParams['params']['schedule_length'];
        $seasonId = $scheduleParams['params']['season_id'];
        $startDate = \DateTime::createFromFormat('Y-m-d', $scheduleParams['params']['start_date']);
        $endDate = \DateTime::createFromFormat('Y-m-d', $scheduleParams['params']['end_date']);

        $dates = [];
        $interval = new \DateInterval('P7D'); // 7 day interval
        $period = new \DatePeriod($startDate, $interval, $endDate->modify('+1 day')); // Include end date

        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        try {
            // Fetch template for the number of weeks specified
            $scheduleTemplate = DB::table('schedule_template')
                ->where('week_number', '<=', $scheduleLength)
                ->get();
        } catch (Exception $e) {
            return 'Exception when fetching schedule template: ' . $e->getMessage();
        }

        try {
            // get teams for the season_id specified
            $seasonTeams = DB::table('teams')
                ->where('season_id', '=', $seasonId)
                ->get();
        } catch (Exception $e) {
            return "Exception when fetching teams for season_id $seasonId: " . $e->getMessage();
        }

        $scheduledGames = [];

        for ($i = 1; $i <= $scheduleLength; $i++) {
            foreach ($scheduleTemplate as $gameSchedule) {
                $game = [];
                if ($gameSchedule->week_number === $i) {
                    $homeTeamIndex = (int) $gameSchedule->home_team - 1;
                    $awayTeamIndex = (int) $gameSchedule->away_team - 1;
                    $game['season_id'] = $seasonId;
                    $game['home_team'] = $seasonTeams[$homeTeamIndex]->id;
                    $game['away_team'] = $seasonTeams[$awayTeamIndex]->id;
                    $game['game_date_time'] = $dates[$i - 1] . " " . $gameSchedule->time;

                    $scheduledGames[] = $game;
                }

            }
        }

        try {
            // Insert game schedules
            foreach ($scheduledGames as $scheduledGame) {
                DB::selectOne(
                    "INSERT INTO schedules (season_id, home_team, away_team, game_date_time)
                    VALUES (?, ?, ?, ?)",
                    [
                        $scheduledGame['season_id'],
                        $scheduledGame['home_team'],
                        $scheduledGame['away_team'],
                        $scheduledGame['game_date_time']
                    ]
                );
            }
        } catch (Exception $e) {
            return 'Exception when inserting schedules: ' . $e->getMessage();
        }

        return 'Schedule successfully saved. Press ESC to continue.';
    }
}
