<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30Attributes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BioDetailsController extends Controller
{
    
    // --------------------------------------------------------------
    //  1️⃣  Show the BIO Details 
    // --------------------------------------------------------------
    public function bioDetails()
    {
        $userId = auth()->id();

        // only fetch 8 bio-related columns
        $fields = ['UserID', 'BioPhotoPath', 'BioBackgroundPhotoPath', 'BioTextParagraph1', 'BioTextParagraph2', 'BioTextParagraph3', 'BioTextParagraph4', 'BioTextParagraph5', 'BioTextParagraph6',];

        $bio = SysUserType30Attributes::where('UserID', $userId)
            ->select($fields)
            ->first();

        return view('modules.mod-10.01-counselling.therapists.my-bio.bio-details', compact('bio'));
    }

    //2️⃣  Store BIO Details    
    public function storeBioDetails(Request $request)
    {
        $validated = $request->validate([
            'BioPhotoPath'           => 'nullable|image|mimes:jpg,jpeg,png|max:3072',     // 3 MB
            'BioBackgroundPhotoPath' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',     // 5 MB
            'BioTextParagraph1'      => 'nullable|string',
            'BioTextParagraph2'      => 'nullable|string',
            'BioTextParagraph3'      => 'nullable|string',
            'BioTextParagraph4'      => 'nullable|string',
            'BioTextParagraph5'      => 'nullable|string',
            'BioTextParagraph6'      => 'nullable|string',
        ]);

        $userId = auth()->id();

        $existing = SysUserType30Attributes::where('UserID', $userId)
            ->select([
                'UserID',
                'BioPhotoPath',
                'BioBackgroundPhotoPath',
                'BioTextParagraph1',
                'BioTextParagraph2',
                'BioTextParagraph3',
                'BioTextParagraph4',
                'BioTextParagraph5',
                'BioTextParagraph6',
            ])
            ->first();

        // handle BioPhotoPath
        if ($request->hasFile('BioPhotoPath')) {
            if ($existing && $existing->BioPhotoPath && Storage::disk('public')->exists($existing->BioPhotoPath)) {
                Storage::disk('public')->delete($existing->BioPhotoPath);
            }
            $validated['BioPhotoPath'] = $request->file('BioPhotoPath')->store('bio_images', 'public');
        }

        // handle BioBackgroundPhotoPath
        if ($request->hasFile('BioBackgroundPhotoPath')) {
            if ($existing && $existing->BioBackgroundPhotoPath && Storage::disk('public')->exists($existing->BioBackgroundPhotoPath)) {
                Storage::disk('public')->delete($existing->BioBackgroundPhotoPath);
            }
            $validated['BioBackgroundPhotoPath'] = $request->file('BioBackgroundPhotoPath')->store('bio_backgrounds', 'public');
        }

        // Create or update record
        $bio = SysUserType30Attributes::updateOrCreate(
            ['UserID' => $userId],
            $validated
        );

        // Convert storage paths to URLs for instant UI update
        if ($bio->BioPhotoPath) {
            $bio->BioPhotoPath = $bio->BioPhotoPath ? $bio->BioPhotoPath : null;
        }
        if ($bio->BioBackgroundPhotoPath) {
            $bio->BioBackgroundPhotoPath = $bio->BioBackgroundPhotoPath ? $bio->BioBackgroundPhotoPath : null;
        }


        return response()->json([
            'success' => true,
            'message' => 'BIO details saved successfully!',
            'bio' => $bio
        ]);
    }

    //3️⃣  Update BIO Details    
    public function updateBioDetails(Request $request)
    {
        try {
            $userId = auth()->id();
            $biodetails = SysUserType30Attributes::firstOrNew(['UserID' => $userId]);

            if (!$request->has('field')) {
                return response()->json(['success' => false, 'message' => 'No field provided']);
            }

            $field = $request->input('field');
            $allowed = ['BioTextParagraph1', 'BioTextParagraph2', 'BioTextParagraph3', 'BioTextParagraph4', 'BioTextParagraph5', 'BioTextParagraph6', 'BioPhotoPath', 'BioBackgroundPhotoPath'];

            if (!in_array($field, $allowed)) {
                return response()->json(['success' => false, 'message' => 'Invalid field name.']);
            }

            $path = null;

            // === 🟢 STEP 1: Handle image upload ===
            if (in_array($field, ['BioPhotoPath', 'BioBackgroundPhotoPath']) && $request->hasFile('value')) {
                $file = $request->file('value');
                $ext = $file->getClientOriginalExtension();
                $uniqueName = uniqid('bio_', true) . '.' . $ext;
                $folder = $field === 'BioPhotoPath' ? 'bio_images' : 'bio_backgrounds';
                $path = $file->storeAs($folder, $uniqueName, 'public');

                // Delete old file if exists
                if (!empty($biodetails->$field) && Storage::disk('public')->exists($biodetails->$field)) {
                    Storage::disk('public')->delete($biodetails->$field);
                }

                $biodetails->$field = $path;
                clearstatcache();
            } else {
                // Text fields
                $biodetails->$field = trim(mb_convert_encoding($request->input('value', ''), 'UTF-8', 'auto'));
            }

            $biodetails->UserID = $userId;
            $biodetails->save();

            // 🟢 STEP 2: Clean buffer before sending JSON (fixes "Invalid JSON response")
            if (ob_get_length()) ob_clean();

            // 🟢 STEP 3: Return pure JSON
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Updated successfully',
                    'newPath' => $path,
                ], 200)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Content-Type', 'application/json; charset=utf-8');
        } catch (\Throwable $e) {
            Log::error('Bio update error', ['error' => $e->getMessage()]);

            // 🟢 STEP 4: Clean buffer for safety on errors too
            if (ob_get_length()) ob_clean();

            return response()->json(['success' => false, 'message' => 'Server error.']);
        }
    }

    //4️⃣  Delete BIO Details    
    public function deleteBioDetails()
    {
        $userId = auth()->id();

        $fields = ['BioPhotoPath', 'BioBackgroundPhotoPath', 'BioTextParagraph1', 'BioTextParagraph2', 'BioTextParagraph3', 'BioTextParagraph4', 'BioTextParagraph5', 'BioTextParagraph6',];

        $biodetails = SysUserType30Attributes::where('UserID', $userId)->first();

        if (! $biodetails) {
            return redirect()->route('my-bio-details')
                ->with('info', 'No bio record found to delete.');
        }

        // Track images before clearing
        $filesToDelete = [
            $biodetails->BioPhotoPath,
            $biodetails->BioBackgroundPhotoPath,
        ];

        // Check if any data exists
        $hasData = collect($fields)->some(fn($f) => !empty($biodetails->{$f}));

        if (! $hasData) {
            return redirect()->route('my-bio-details')
                ->with('info', 'Bio record found but already empty.');
        }

        // Bulk null update
        $biodetails->update(array_fill_keys($fields, null));

        // Delete images physically
        foreach ($filesToDelete as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'All bio details deleted successfully.'
        ]);
    }

}
