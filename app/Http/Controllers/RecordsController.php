<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RecordsController extends Controller
{
    public function getRecords(Request $request): Response
    {
        $allTimeRecords = DB::table('all_time_records')
            ->get();

        $processedRecords = [];

        foreach ($allTimeRecords as $record) {
            if (isset($processedRecords[$record->record_name])) {
                $processedRecords[$record->record_name][] = [$record->player_team_name, $record->record_text, $record->record_accomplished];
            } else {
                $processedRecords[$record->record_name] = [[$record->player_team_name, $record->record_text, $record->record_accomplished]];
            }
        }

        return Inertia::render('Records', ['records' => $processedRecords]);
    }
}
