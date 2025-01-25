<?php
namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
    // Fetch all habits for the authenticated user
    public function index()
    {
        $habits = Habit::where('user_id', Auth::id())->get();

        return response()->json(['habits' => $habits], 200);
    }

    // Create a new habit
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency' => 'required|in:Daily,Weekly',
        ]);

        $habit = Habit::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'frequency' => $request->frequency,
        ]);

        return response()->json(['message' => 'Habit created successfully', 'habit' => $habit], 201);
    }

    // Fetch a specific habit by ID
    public function show($id)
    {
        $habit = Habit::where('user_id', Auth::id())->find($id);

        if (!$habit) {
            return response()->json(['message' => 'Habit not found'], 404);
        }

        return response()->json(['habit' => $habit], 200);
    }

    // Update a specific habit
    public function update(Request $request, $id)
    {
        $habit = Habit::where('user_id', Auth::id())->find($id);

        if (!$habit) {
            return response()->json(['message' => 'Habit not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency' => 'required|in:Daily,Weekly',
        ]);

        $habit->update([
            'title' => $request->title,
            'description' => $request->description,
            'frequency' => $request->frequency,
        ]);

        return response()->json(['message' => 'Habit updated successfully', 'habit' => $habit], 200);
    }

    // Delete a specific habit
    public function destroy($id)
    {
        $habit = Habit::where('user_id', Auth::id())->find($id);

        if (!$habit) {
            return response()->json(['message' => 'Habit not found'], 404);
        }

        $habit->delete();

        return response()->json(['message' => 'Habit deleted successfully'], 200);
    }
}
