<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30Attributes;
use App\Models\SysUserType30TasksAction;
use App\Models\SysUserType30SessionHistory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TasksActionsController extends Controller
{
    // 1️⃣ 2️⃣ 3️⃣ 4️⃣
    public function tasksActions()
    {
        $user = Auth::user();

        if (! $user || ($user->UserType ?? null) != 30) {
            abort(403, 'Unauthorized');
        }

        // Tasks belonging to this therapist
        $tasks = SysUserType30TasksAction::where('TherapistUserID', $user->ID)
            ->orderBy('DueDate')
            ->get();

        // Find distinct patients from session history for this therapist
        $patientIds = SysUserType30SessionHistory::where('AllocatedTherapistUserID', $user->ID)
            ->pluck('PatientUserID')
            ->unique()
            ->filter()
            ->values()
            ->all();

        $patients = User::whereIn('ID', $patientIds)
            ->get()
            ->map(function ($u) {
                $profile = is_array($u->ProfileData) ? $u->ProfileData : [];
                return [
                    'ID' => $u->ID,
                    'UserName' => $u->UserName,
                    'FirstName' => $u->FirstName ?? ($profile['first_name'] ?? null),
                    'LastName' => $u->LastName ?? ($profile['last_name'] ?? null),
                ];
            });

        return view('modules.mod-10.01-counselling.therapists.tasks-actions', compact('tasks', 'patients'));
    }

    /**
     * Store a new task for the authenticated therapist (AJAX)
     */
    public function storeTask(Request $request)
    {
        $user = Auth::user();
        if (! $user || ($user->UserType ?? null) != 30) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'PatientUserID' => 'nullable|integer|exists:users,ID',
            'TaskTitle' => 'nullable|string|max:64',
            'TaskNotes' => 'nullable|string|max:2048',
            'TaskAssignedTo' => 'required|string|in:Self,Patient,Assistant,Team Leader',
            'DueDate' => 'nullable|date',
            'TaskPrioity' => 'nullable|string|in:Low,Medium,High,Urgent',
            'TaskStatus' => 'nullable|string|in:Open,In Progress,On Hold,Closed',
        ]);

        $task = SysUserType30TasksAction::create(array_merge($data, [
            'TherapistUserID' => $user->ID,
        ]));

        return response()->json(['success' => true, 'task' => $task]);
    }

    /**
     * Update an existing task (AJAX)
     */
    public function updateTask(Request $request)
    {
        $user = Auth::user();
        if (! $user || ($user->UserType ?? null) != 30) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'ID' => 'required|integer|exists:sys_user_type_30_tasks_actions,ID',
            'PatientUserID' => 'nullable|integer|exists:users,ID',
            'TaskTitle' => 'nullable|string|max:64',
            'TaskNotes' => 'nullable|string|max:2048',
            'TaskAssignedTo' => 'required|string|in:Self,Patient,Assistant,Team Leader',
            'DueDate' => 'nullable|date',
            'TaskPrioity' => 'nullable|string|in:Low,Medium,High,Urgent',
            'TaskStatus' => 'nullable|string|in:Open,In Progress,On Hold,Closed',
        ]);

        $task = SysUserType30TasksAction::where('ID', $data['ID'])
            ->where('TherapistUserID', $user->ID)
            ->first();

        if (! $task) {
            return response()->json(['error' => 'Task not found or unauthorized'], 404);
        }

        $task->update($data);

        return response()->json(['success' => true, 'task' => $task]);
    }

    /**
     * Delete a task (AJAX)
     */
    public function deleteTask(Request $request)
    {
        $user = Auth::user();
        if (! $user || ($user->UserType ?? null) != 30) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $id = $request->input('ID');
        if (! $id) {
            return response()->json(['error' => 'Missing ID'], 400);
        }

        $task = SysUserType30TasksAction::where('ID', $id)
            ->where('TherapistUserID', $user->ID)
            ->first();

        if (! $task) {
            return response()->json(['error' => 'Task not found or unauthorized'], 404);
        }

        $task->delete();

        return response()->json(['success' => true]);
    }
}