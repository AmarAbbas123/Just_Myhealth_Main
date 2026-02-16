<?php

namespace App\Http\Controllers\ZegoCloud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ZegoRecordingService;
use App\Models\SysUserType30SessionHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ZegoRecordingController extends Controller
{

    public function start(Request $request, ZegoRecordingService $zego)
    {
        $roomId = $request->room_id;
        $shouldStart = $request->input('start', true); // Capture the true/false flag

        if (!$shouldStart) {
            // Check if we actually have the task ID before calling the service
            $existingTask = DB::table('sys_user_type_30_session_history')
                ->where('SessionZegoCloudConnectID', trim($roomId))
                ->value('zego_task_id');

            Log::info("Stop Recording Request for Room: $roomId. Found Task ID in DB: " . ($existingTask ?? 'NULL'));
            $result = $zego->stopCloudRecording($roomId); // Call the stop service
            return response()->json(['message' => 'Stop request sent', 'result' => $result]);
        }

        Log::info("Start Recording Request received for Room: " . $roomId);

        // 1. Call Zego first
        $result = $zego->startCloudRecording($roomId);

        if (isset($result['Code']) && $result['Code'] === 0) {
            $taskId = $result['Data']['TaskId'];

            // 2. Update the DB with the Task ID
            $affected = DB::table('sys_user_type_30_session_history')
                ->where('SessionZegoCloudConnectID', trim($roomId))
                ->update(['zego_task_id' => $taskId]);

            if ($affected > 0) {
                Log::info("✅ Successfully linked Task ID $taskId to Room $roomId");
            } else {
                // This is where your previous log was confusing
                Log::error("❌ Recording started in Zego, but Room ID $roomId was NOT found in DB.");
            }

            return response()->json(['message' => 'Recording started', 'task_id' => $taskId]);
        }

        Log::error("❌ Zego API Rejected Recording:", ['response' => $result]);
        return response()->json(['message' => 'Failed', 'error' => $result], 400);
    }

    public function handleCallback(Request $request)
    {

        // Try to get data from request, if empty, try raw content
        $data = $request->all();
        if (empty($data)) {
            $data = json_decode($request->getContent(), true);
        }

        Log::info('--- ZEGO CALLBACK HIT ---');
        Log::info('Payload: ' . json_encode($data));

        if (isset($data['event_type']) && $data['event_type'] == 1) {
            $taskId = $data['task_id'];

            // In event_type 1, the files are in detail -> file_info
            $fileInfo = $data['detail']['file_info'] ?? [];

            if (!empty($fileInfo)) {
                // Get the first file's URL
                $fileUrl = $fileInfo[0]['file_url'];

                // Use the model to update
                $updated = SysUserType30SessionHistory::where('zego_task_id', $taskId)
                    ->update(['LinkToSessionRecording' => $fileUrl]);

                if ($updated) {
                    Log::info("✅ DB Updated for Task: $taskId");
                } else {
                    // If Task ID fails, fallback to Room ID as a backup
                    $roomId = $data['room_id'] ?? null;
                    $updatedFallback = SysUserType30SessionHistory::where('SessionZegoCloudConnectID', $roomId)
                        ->update(['LinkToSessionRecording' => $fileUrl]);

                    if ($updatedFallback) {
                        Log::info("✅ URL Saved via Room ID Fallback: $roomId");
                    } else {
                        Log::error("❌ Failed to link recording. Task: $taskId, Room: $roomId");
                    }
                }
            }
        }
        return response()->json(['code' => 0]);
    }
}
