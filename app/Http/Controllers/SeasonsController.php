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
}
