<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    // Step 1: Get all users
    $users = DB::table('users')->get();

    foreach ($users as $user) {
        // Step 2: Get all habits for the current user
        $habits = DB::table('habits')->where('user_id', $user->id)->get();

        // Step 3: Get the current date and calculate yesterday's date
        $yesterday = now()->subDay()->toDateString();

        foreach ($habits as $habit) {
            // Step 4: Check if a habit log exists for the habit on yesterday's date
            $logExists = DB::table('habit_logs')
                ->where('habit_id', $habit->id)
                ->whereDate('date', $yesterday)
                ->exists();

            // Step 5: If no log exists, create a new record with status "Skipped"
            if (!$logExists) {
                DB::table('habit_logs')->insert([
                    'habit_id' => $habit->id,
                    'date' => $yesterday,
                    'status' => 'Skipped',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
})->everyTenSeconds();