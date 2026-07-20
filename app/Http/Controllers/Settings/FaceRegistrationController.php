<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\FaceDescriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaceRegistrationController extends Controller
{
    /**
     * Show the "register your face" panel in account settings.
     */
    public function edit(Request $request)
    {
        $existing = FaceDescriptor::where('user_id', $request->user()->getKey())->first();

        return view('settings.face-login', [
            'faceRegistered' => (bool) $existing,
            'registeredAt' => $existing?->RegisteredAt,
        ]);
    }

    /**
     * Store (or replace) the authenticated user's face descriptor.
     * Expects an array of arrays: several samples of 128 floats each,
     * captured client-side by face-api.js, which we average server-side.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'samples' => ['required', 'array', 'min:1', 'max:5'],
            'samples.*' => ['array', 'size:128'],
            'samples.*.*' => ['numeric'],
        ]);

        $samples = $validated['samples'];
        $sampleCount = count($samples);

        // Average the samples into a single descriptor for a more stable match.
        $averaged = array_fill(0, 128, 0.0);
        foreach ($samples as $sample) {
            foreach ($sample as $i => $value) {
                $averaged[$i] += $value;
            }
        }
        foreach ($averaged as $i => $value) {
            $averaged[$i] = $value / $sampleCount;
        }

        FaceDescriptor::updateOrCreate(
            ['user_id' => $request->user()->getKey()],
            [
                'Descriptor' => $averaged,
                'SampleCount' => $sampleCount,
                'RegisteredAt' => now(),
            ]
        );

        return response()->json([
            'message' => 'Face registered. You can now use face login.',
        ]);
    }

    /**
     * Remove the authenticated user's face profile (turns off face login for them).
     */
    public function destroy(Request $request)
    {
        FaceDescriptor::where('user_id', $request->user()->getKey())->delete();

        return response()->json([
            'message' => 'Face login has been turned off for your account.',
        ]);
    }
}