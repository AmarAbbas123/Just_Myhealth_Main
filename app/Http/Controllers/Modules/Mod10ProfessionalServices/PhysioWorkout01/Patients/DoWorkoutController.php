<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\PhysioWorkout01\Patients;

use App\Http\Controllers\Controller;
use App\Models\SysWorkoutAssignment;
use App\Models\SysWorkoutSessionAi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoWorkoutController extends Controller
{
    // List active workouts assigned to the logged-in patient
    public function index()
    {
        $assignments = SysWorkoutAssignment::with('exercise')
            ->where('PatientID', Auth::id())
            ->where('Status', 'active')
            ->orderByDesc('created_at')
            ->get();

        return view('modules.mod-10.02-physio-workout.patients.my-workouts', compact('assignments'));
    }

    // The actual "do this exercise" page — webcam + AI pose detection lives here
    public function show(SysWorkoutAssignment $assignment)
    {
        abort_unless($assignment->PatientID == Auth::id(), 403);
        $assignment->load('exercise');

        return view('modules.mod-10.02-physio-workout.patients.do-workout', compact('assignment'));
    }

    // Called by the Alpine/MediaPipe frontend once a set is finished,
    // with the results the in-browser AI checker computed.
    public function storeResult(Request $request, SysWorkoutAssignment $assignment)
    {
        abort_unless($assignment->PatientID == Auth::id(), 403);

        $validated = $request->validate([
            'DurationSeconds' => 'required|integer|min:0',
            'RepsCompleted'   => 'required|integer|min:0',
            'RepsGoodForm'    => 'required|integer|min:0',
            'RepsBadForm'     => 'required|integer|min:0',
            'AvgFormScore'    => 'required|integer|min:0|max:100',
            'RepDetails'      => 'nullable|array',
        ]);

        $session = SysWorkoutSessionAi::create([
            'AssignmentID' => $assignment->ID,
            'PatientID' => Auth::id(),
            'ExerciseID' => $assignment->ExerciseID,
            'EntryMethod' => 'ai_camera',
            'AttemptedAt' => now(),
            'DurationSeconds' => $validated['DurationSeconds'],
            'RepsCompleted' => $validated['RepsCompleted'],
            'RepsGoodForm' => $validated['RepsGoodForm'],
            'RepsBadForm' => $validated['RepsBadForm'],
            'AvgFormScore' => $validated['AvgFormScore'],
            'RepDetails' => $validated['RepDetails'] ?? [],
        ]);

        return response()->json([
            'success' => true,
            'session_id' => $session->ID,
            'message' => 'Great work! Your session has been logged for your therapist to review.',
        ]);
    }

    // Fallback for patients without a usable camera/lighting: they self-report
    // reps and how many felt like good form, no AI scoring involved. Flagged
    // via EntryMethod so therapists can see which sessions were AI-verified
    // vs self-reported when reviewing progress.
    public function storeManualResult(Request $request, SysWorkoutAssignment $assignment)
    {
        abort_unless($assignment->PatientID == Auth::id(), 403);

        $validated = $request->validate([
            'RepsCompleted' => 'required|integer|min:0|max:500',
            'RepsGoodForm'  => 'required|integer|min:0|max:500|lte:RepsCompleted',
            'Notes'         => 'nullable|string|max:1000',
        ]);

        $repsBad = $validated['RepsCompleted'] - $validated['RepsGoodForm'];
        $avgFormScore = $validated['RepsCompleted'] > 0
            ? (int) round(($validated['RepsGoodForm'] / $validated['RepsCompleted']) * 100)
            : 0;

        $session = SysWorkoutSessionAi::create([
            'AssignmentID' => $assignment->ID,
            'PatientID' => Auth::id(),
            'ExerciseID' => $assignment->ExerciseID,
            'EntryMethod' => 'manual',
            'AttemptedAt' => now(),
            'DurationSeconds' => 0,
            'RepsCompleted' => $validated['RepsCompleted'],
            'RepsGoodForm' => $validated['RepsGoodForm'],
            'RepsBadForm' => $repsBad,
            'AvgFormScore' => $avgFormScore,
            'RepDetails' => ['self_reported_notes' => $validated['Notes'] ?? null],
        ]);

        return back()->with('success', 'Self-reported session saved. Note: this was not AI-verified.');
    }

    // Patient's own history for one assignment
    public function history(SysWorkoutAssignment $assignment)
    {
        abort_unless($assignment->PatientID == Auth::id(), 403);

        $sessions = SysWorkoutSessionAi::where('AssignmentID', $assignment->ID)
            ->orderByDesc('AttemptedAt')
            ->get();

        return view('modules.mod-10.02-physio-workout.patients.workout-history', compact('assignment', 'sessions'));
    }
}
