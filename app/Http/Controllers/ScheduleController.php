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
}
