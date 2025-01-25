<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
 * Get the current streak for a specific habit by ID.
 */
public function streak($id)
{
    try {
        $habit = Habit::where('user_id', Auth::id())->find($id);

        if (!$habit) {
            return response()->json(['message' => 'Habit not found or access denied'], 404);
        }

        $logs = HabitLog::where('habit_id', $habit->id)
            ->orderBy('date', 'desc')
            ->get();

        $currentStreak = 0;
        $streakBroken = false;

        foreach ($logs as $log) {
            if ($log->status === 'Completed') {
                $currentStreak++;
            } else {
                $streakBroken = true;
                break;
            }
        }

        return response()->json([
            'habit_title' => $habit->title,
            'current_streak' => $currentStreak,
            'streak_broken' => $streakBroken,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function completion()
{
    try {
        $userId = Auth::id();
        $habits = Habit::where('user_id', $userId)->get();

        $completionSummary = $habits->map(function ($habit) {
            $logs = HabitLog::where('habit_id', $habit->id)->get();

            $totalLogs = $logs->count();
            $completed = $logs->where('status', 'Completed')->count();
            $missed = $logs->where('status', 'Skipped')->count();

            return [
                'habit_title' => $habit->title,
                'total_logs' => $totalLogs,
                'completed' => $completed,
                'missed' => $missed,
                'completion_rate' => $totalLogs > 0 ? round(($completed / $totalLogs) * 100, 2) : 0,
            ];
        });

        return response()->json(['completion_summary' => $completionSummary], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
