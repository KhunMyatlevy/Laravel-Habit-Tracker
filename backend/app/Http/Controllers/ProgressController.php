<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Habit;
use App\Models\HabitLog;

class ProgressController extends Controller
{
    public function track(Request $request, $id)
    {
        try {
            $habit = Habit::where('user_id', Auth::id())->find($id);
    
            if (!$habit) {
                return response()->json(['message' => 'Habit not found or access denied'], 404);
            }
    
            $request->validate([
                'date' => 'required|date',
                'status' => 'required|in:Completed,Skipped',
            ]);
    
            // Check if a log already exists for the given date
            $log = HabitLog::firstOrNew([
                'habit_id' => $habit->id,
                'date' => $request->date,
            ]);
    
            $log->status = $request->status;
            $log->save();
    
            return response()->json(['message' => 'Habit tracked successfully', 'log' => $log], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function habitHistory($id)
    {
        $userId = Auth::id();
        $habit = Habit::where('user_id', $userId)->find($id);

        if (!$habit) {
            return response()->json(['message' => 'Habit not found or access denied'], 404);
        }

        // Get the first and last day of the current month
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Fetch habit logs within the current month
        $logs = HabitLog::where('habit_id', $id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date', 'asc')
            ->get(['date', 'status']);

        // Count how many are completed and how many are skipped
        $completedCount = $logs->where('status', 'Completed')->count();
        $skippedCount = $logs->where('status', 'Skipped')->count();
        $totalCount = $logs->count(); // Total logs in the current month

        // Return the habit history along with completion ratio
        return response()->json([
            'habit' => $habit,
            'logs' => $logs,
            'completed_count' => $completedCount,
            'skipped_count' => $skippedCount,
            'completion_ratio' => "{$completedCount}/{$totalCount}", // Completion ratio
        ], 200);
    }
}
