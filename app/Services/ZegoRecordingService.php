<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SysUserType30SessionHistory;

class ZegoRecordingService
{

    public function startCloudRecording($roomId)
    {
        // 1. Ensure keys are clean of spaces
        $appId = (int)config('services.zegocloud.app_id');
        $serverSecret = config('services.zegocloud.server_secret');

        $timestamp = time();
        $nonce = bin2hex(random_bytes(8));
        $signature = md5($appId . $nonce . $serverSecret . $timestamp);

        $queryParams = [
            'Action' => 'StartRecord',
            'AppId' => $appId,
            'SignatureNonce' => $nonce,
            'Timestamp' => $timestamp,
            'Signature' => $signature,
            'SignatureVersion' => '2.0'
        ];

        $body = [
            "RoomId" => (string) $roomId,
            "RecordInputParams" => [
                "RecordMode" => 2,
                "StreamType" => 3,
                "MaxIdleTime" => 10,
                "MixConfig" => [
                    "MixMode" => 2,
                    "MixOutputStreamId" => "mix_" . $roomId,
                    "MixOutputVideoConfig" => [
                        "Width" => 1280,
                        "Height" => 720,
                        "Fps" => 15,
                        "Bitrate" => 1130000
                    ]
                ]
            ],
            "RecordOutputParams" => [
                "OutputFileFormat" => "mp4",
                "CallbackUrl" => "https://jmhdev.xyz/zego/callback" // Moved here
            ],
            "StorageParams" => [
                "Vendor" => 1,
                "Region" => config('services.zegocloud.s3_region'),
                "Bucket" => config('services.zegocloud.s3_bucket'),
                "AccessKeyId" => config('services.zegocloud.aws_key'),
                "AccessKeySecret" => config('services.zegocloud.aws_secret')
            ]
        ];

        $url = "https://cloudrecord-api.zego.im/?" . http_build_query($queryParams);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->timeout(30)
                ->post($url, $body);
            Log::info("Zego Sent Body: ", $body); // Check your logs to see exactly what went out
            Log::info("Zego API Response: " . $response->body());
            return $response->json();
        } catch (\Exception $e) {
            Log::error("Zego Service Error: " . $e->getMessage());
            return ["Code" => 500, "Message" => $e->getMessage()];
        }
    }

    public function stopCloudRecording($roomId)
    {
        // 1. Fetch the Task ID from the database using the Room ID
        $session = SysUserType30SessionHistory::where('SessionZegoCloudConnectID', trim($roomId))->first();

        if (!$session || empty($session->zego_task_id)) {
            Log::error("❌ Cannot stop recording: No Task ID found for Room: $roomId");
            return ["Code" => 404, "Message" => "Task ID not found in DB"];
        }

        $taskId = $session->zego_task_id;
        $appId = (int)config('services.zegocloud.app_id');
        $serverSecret = config('services.zegocloud.server_secret');

        $timestamp = time();
        $nonce = bin2hex(random_bytes(8));
        $signature = md5($appId . $nonce . $serverSecret . $timestamp);

        $queryParams = [
            'Action' => 'StopRecord', // Changed action
            'AppId' => $appId,
            'SignatureNonce' => $nonce,
            'Timestamp' => $timestamp,
            'Signature' => $signature,
            'SignatureVersion' => '2.0'
        ];

        $body = [
            "TaskId" => $taskId // Zego needs the Task ID to know which recording to stop
        ];

        $url = "https://cloudrecord-api.zego.im/?" . http_build_query($queryParams);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->timeout(30)
                ->post($url, $body);

            Log::info("Zego Stop Request Sent for Task: $taskId");
            Log::info("Zego Stop API Response: " . $response->body());

            return $response->json();
        } catch (\Exception $e) {
            Log::error("Zego Stop Service Error: " . $e->getMessage());
            return ["Code" => 500, "Message" => $e->getMessage()];
        }
    }
}
