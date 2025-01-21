<?php

namespace App\Http\Controllers;

use App\Models\CoachingSession;


class AnalyticsController extends Controller
{
    public function totalSessions()
    {
        $total = CoachingSession::count();
        return response()->json(['total_sessions' => $total]);
    }

    public function clientProgress()
    {
        $progress = CoachingSession::selectRaw('client_id, COUNT(*) as total_sessions, SUM(completed) as completed_sessions')
            ->groupBy('client_id')
            ->get()
            ->map(function ($item) {
                $item->progress = $item->completed_sessions / $item->total_sessions * 100;
                return $item;
            });

        return response()->json($progress);
    }
    
    
}

