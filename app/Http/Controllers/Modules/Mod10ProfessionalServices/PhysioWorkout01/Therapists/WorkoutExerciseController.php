<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\PhysioWorkout01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30SessionHistory;
use App\Models\SysWorkoutAssignment;
use App\Models\SysWorkoutExercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutExerciseController extends Controller
{
    // List this therapist's exercise library, plus their real client list for the assign picker
    public function index()
    {
        $exercises = SysWorkoutExercise::where('CreatedByTherapistID', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        // Reuses the same "who is my client" logic as SessionHistoryByClientsController,
        // so the assign picker only ever shows patients this therapist has actually seen.
        $clients = SysUserType30SessionHistory::where('AllocatedTherapistUserID', Auth::id())
            ->whereNotNull('PatientUserID')
            ->with('patient')
            ->get()
            ->unique('PatientUserID')
            ->pluck('patient')
            ->filter()
            ->values();

        return view('modules.mod-10.02-physio-workout.therapists.exercise-library', compact('exercises', 'clients'));
    }

    // Store a new exercise template with its AI angle-rule config
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ExerciseName'   => 'required|string|max:150',
            'ExerciseType'   => 'required|string|in:knee_squat,shoulder_raise,elbow_curl,generic_angle',
            'BodyPart'       => 'nullable|string|max:100',
            'Instructions'   => 'nullable|string',
            'Joint'          => 'required|string|in:knee,shoulder,elbow,hip',
            'Side'           => 'required|string|in:left,right,both',
            'DownAngleMax'   => 'required|integer|min:0|max:180',
            'UpAngleMin'     => 'required|integer|min:0|max:180',
            'GoodFormTolerance' => 'required|integer|min:1|max:60',
            'DefaultSets'    => 'required|integer|min:1|max:20',
            'DefaultReps'    => 'required|integer|min:1|max:100',
        ]);

        SysWorkoutExercise::create([
            'CreatedByTherapistID' => Auth::id(),
            'ExerciseName' => $validated['ExerciseName'],
            'ExerciseType' => $validated['ExerciseType'],
            'BodyPart' => $validated['BodyPart'] ?? null,
            'Instructions' => $validated['Instructions'] ?? null,
            'AngleRuleConfig' => [
                'joint' => $validated['Joint'],
                'side' => $validated['Side'],
                'down_angle_max' => $validated['DownAngleMax'],
                'up_angle_min' => $validated['UpAngleMin'],
                'good_form_tolerance' => $validated['GoodFormTolerance'],
            ],
            'DefaultSets' => $validated['DefaultSets'],
            'DefaultReps' => $validated['DefaultReps'],
            'IsActive' => true,
        ]);

        return back()->with('success', 'Exercise added to your library.');
    }

    public function update(Request $request, SysWorkoutExercise $exercise)
    {
        abort_unless($exercise->CreatedByTherapistID == Auth::id(), 403);

        $validated = $request->validate([
            'ExerciseName'   => 'required|string|max:150',
            'Instructions'   => 'nullable|string',
            'DownAngleMax'   => 'required|integer|min:0|max:180',
            'UpAngleMin'     => 'required|integer|min:0|max:180',
            'GoodFormTolerance' => 'required|integer|min:1|max:60',
            'IsActive'       => 'required|boolean',
        ]);

        $config = $exercise->AngleRuleConfig;
        $config['down_angle_max'] = $validated['DownAngleMax'];
        $config['up_angle_min'] = $validated['UpAngleMin'];
        $config['good_form_tolerance'] = $validated['GoodFormTolerance'];

        $exercise->update([
            'ExerciseName' => $validated['ExerciseName'],
            'Instructions' => $validated['Instructions'] ?? null,
            'AngleRuleConfig' => $config,
            'IsActive' => $validated['IsActive'],
        ]);

        return back()->with('success', 'Exercise updated.');
    }

    public function destroy(SysWorkoutExercise $exercise)
    {
        abort_unless($exercise->CreatedByTherapistID == Auth::id(), 403);
        $exercise->delete();

        return back()->with('success', 'Exercise removed.');
    }

    // Assign an exercise from the library to a specific patient
    public function assign(Request $request)
    {
        $validated = $request->validate([
            'ExerciseID' => 'required|exists:sys_workout_exercises,ID',
            'PatientID'  => 'required|exists:users,ID',
            'SetsTarget' => 'required|integer|min:1|max:20',
            'RepsTarget' => 'required|integer|min:1|max:100',
            'FrequencyPerWeek' => 'required|integer|min:1|max:14',
            'TherapistNotes' => 'nullable|string',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
        ]);

        $exercise = SysWorkoutExercise::findOrFail($validated['ExerciseID']);
        abort_unless($exercise->CreatedByTherapistID == Auth::id(), 403);

        SysWorkoutAssignment::create([
            'TherapistID' => Auth::id(),
            'PatientID' => $validated['PatientID'],
            'ExerciseID' => $validated['ExerciseID'],
            'SetsTarget' => $validated['SetsTarget'],
            'RepsTarget' => $validated['RepsTarget'],
            'FrequencyPerWeek' => $validated['FrequencyPerWeek'],
            'TherapistNotes' => $validated['TherapistNotes'] ?? null,
            'StartDate' => $validated['StartDate'] ?? now()->toDateString(),
            'EndDate' => $validated['EndDate'] ?? null,
            'Status' => 'active',
        ]);

        return back()->with('success', 'Workout assigned to patient.');
    }

    // Therapist view of a patient's AI-scored progress on assigned workouts
   public function patientProgress($patientId)
{
    $patient = \App\Models\User::findOrFail($patientId);

    $assignments = SysWorkoutAssignment::with(['exercise', 'sessions'])
        ->where('TherapistID', Auth::id())
        ->where('PatientID', $patientId)
        ->get();

    return view('modules.mod-10.02-physio-workout.therapists.patient-progress', compact('assignments', 'patient'));
}
}
