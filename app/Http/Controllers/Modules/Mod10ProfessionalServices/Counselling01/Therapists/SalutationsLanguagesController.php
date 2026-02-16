<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30Attributes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalutationsLanguagesController extends Controller
{
    // --------------------------------------------------------------
    // 1️⃣ Show the salutationsLanguages
    // --------------------------------------------------------------
    public function salutationsLanguages()
    {
        $userId = auth()->id();

        // only fetch 3 bio-related columns
        $fields = ['UserID', 'PreferredSalutation', 'LanguagePrimary', 'LanguageSecondary',];

        $salutang = SysUserType30Attributes::where('UserID', $userId)
            ->select($fields)
            ->first();

        return view('modules.mod-10.01-counselling.therapists.my-bio.salutations-languages', compact('salutang'));
    }

    //2️⃣ store
    public function storeSalutationsLanguages(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'PreferredSalutation' => 'nullable|string|max:30',
            'LanguagePrimary'     => 'nullable|string|max:30',
            'LanguageSecondary'   => 'nullable|string|max:30',
        ]);

        // ✅ Get logged-in user's ID
        $userId = auth()->id();

        // ✅ Create or update record based on UserID
        SysUserType30Attributes::updateOrCreate(
            ['UserID' => $userId],
            $validated
        );

        // ✅ Redirect back with success message
        return redirect()
            ->route('my-bio-salutationsLanguages')
            ->with('success', 'Salutations & Languages saved successfully!');
    }
    //3️⃣ update
    public function updateSalutationsLanguages(Request $request)
    {
        try {
            $userId = auth()->id();
            $salutationsDetails = SysUserType30Attributes::firstOrNew(['UserID' => $userId]);

            if (!$request->has('field')) {
                return response()->json(['success' => false, 'message' => 'No field provided']);
            }

            $field = $request->input('field');
            $allowed = ['PreferredSalutation', 'LanguagePrimary', 'LanguageSecondary'];

            if (!in_array($field, $allowed)) {
                return response()->json(['success' => false, 'message' => 'Invalid field name.']);
            }

            // === 🟢 STEP 1: three Text fields ===                
            $salutationsDetails->$field = trim(mb_convert_encoding($request->input('value', ''), 'UTF-8', 'auto'));

            $salutationsDetails->UserID = $userId;
            $salutationsDetails->save();

            // 🟢 STEP 2: Clean buffer before sending JSON (fixes "Invalid JSON response")
            if (ob_get_length()) ob_clean();

            // 🟢 STEP 3: Return pure JSON
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Updated successfully',
                ],);
        } catch (\Throwable $e) {
            Log::error('Salutations update error', ['error' => $e->getMessage()]);

            // 🟢 STEP 4: Clean buffer for safety on errors too
            if (ob_get_length()) ob_clean();

            return response()->json(['success' => false, 'message' => 'Server error.']);
        }
    }

    //4️⃣ delete
    public function deleteSalutationsLanguages()
    {
        $userId = auth()->id();

        $fields = ['PreferredSalutation', 'LanguagePrimary', 'LanguageSecondary'];

        $salutationsdetails = SysUserType30Attributes::where('UserID', $userId)->first();

        if (! $salutationsdetails) {
            return redirect()->route('my-bio-salutationsLanguages')
                ->with('info', 'No Salutations record found to delete.');
        }

        // Check if any data exists
        $hasData = collect($fields)->some(fn($f) => !empty($salutationsdetails->{$f}));

        if (! $hasData) {
            return redirect()->route('my-bio-salutationsLanguages')
                ->with('info', 'Salutations record found but already empty.');
        }

        // Bulk null update
        $salutationsdetails->update(array_fill_keys($fields, null));

        return redirect()->route('my-bio-salutationsLanguages')
            ->with('success', 'Salutations Languages deleted successfully!');
    }
}
