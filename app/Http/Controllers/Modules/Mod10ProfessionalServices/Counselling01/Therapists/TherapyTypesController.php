<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30Attributes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TherapyTypesController extends Controller
{
    // Show Therapy Types page
    public function profileTherapyTypes()
    {
        $attr = SysUserType30Attributes::where('UserID', Auth::id())->first();

        // Prepare therapy sets for blade
        $therapySets = [];
        for ($i = 1; $i <= 5; $i++) {
            $type = $attr?->{"TherapyType$i"};
            $years = $attr?->{"TherapyYearsExperience$i"};

            if ($type) {
                $therapySets[] = [
                    'index' => $i,
                    'type' => $type,
                    'years' => $years,
                ];
            }
        }

        return view('modules.mod-10.01-counselling.therapists.my-bio.therapy-type', compact('attr', 'therapySets'));
    }

    // Store single therapy set
    public function storeTherapyType(Request $request)
    {
        $validated = $request->validate([
            'TherapyType' => 'required|string',
            'TherapyYearsExperience' => 'required|string',
        ]);

        $attr = SysUserType30Attributes::where('UserID', Auth::id())->first();
        if (!$attr) {
            return back()->with('error', 'Your profile attributes record does not exist.');
        }
        // Find first empty slot
        for ($i = 1; $i <= 5; $i++) {
            if (!$attr->{"TherapyType$i"}) {
                $attr->{"TherapyType$i"} = $validated['TherapyType'];
                $attr->{"TherapyYearsExperience$i"} = $validated['TherapyYearsExperience'];
                $attr->save();
                return back()->with('success', 'Therapy Set added successfully.');
            }
        }

        return back()->with('error', 'Maximum 5 therapy types allowed.');
    }

    // Update single therapy set
    public function updateTherapyType(Request $request)
    {
        $validated = $request->validate([
            'Index' => 'required|integer|min:1|max:5',
            'TherapyType' => 'required|string',
            'TherapyYearsExperience' => 'required|string',
        ]);

        $attr = SysUserType30Attributes::where('UserID', Auth::id())->first();
        if (!$attr) {
            return back()->with('error', 'No therapy profile found.');
        }
        $i = $validated['Index'];

        $attr->{"TherapyType$i"} = $validated['TherapyType'];
        $attr->{"TherapyYearsExperience$i"} = $validated['TherapyYearsExperience'];
        $attr->save();

        return back()->with('success', 'Therapy Set updated successfully.');
    }

    // Delete single therapy set
    public function deleteTherapyType(Request $request)
    {
        $validated = $request->validate([
            'Index' => 'required|integer|min:1|max:5',
        ]);

        $attr = SysUserType30Attributes::where('UserID', Auth::id())->first();
        if (!$attr) {
            return back()->with('error', 'No therapy profile found.');
        }

        $i = $validated['Index'];

        $attr->{"TherapyType$i"} = null;
        $attr->{"TherapyYearsExperience$i"} = null;
        $attr->save();

        return back()->with('success', 'Therapy Set removed.');
    }
}
