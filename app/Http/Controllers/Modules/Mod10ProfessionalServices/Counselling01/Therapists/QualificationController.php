<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30Attributes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QualificationController extends Controller
{
    // --------------------------------------------------------------
    // 1️⃣ Show (QUALIFICATIONS) 
    // --------------------------------------------------------------
    public function qualification()
    {
        $userId = auth()->id();
        $qualf = SysUserType30Attributes::where('UserID', $userId)->first();
        return view('modules.mod-10.01-counselling.therapists.my-bio.qualification', compact('qualf'));
    }
    //2️⃣  Store qualification
    public function storeQualification(Request $request)
    {
        $userId = auth()->id();
        $qualf = SysUserType30Attributes::firstOrCreate(['UserID' => $userId]);
    
        // current index from the form
        $currentIndex = null;
        foreach (range(1,4) as $i) {
            if ($request->has("QualificationTitle{$i}") || $request->hasFile("QualificationImagePath{$i}")) {
                $currentIndex = $i;
                break;
            }
        }
    
        if (!$currentIndex) {
            return back()->with('error', 'No qualification data found.');
        }
    
        $rules = [
            "QualificationTitle{$currentIndex}" => 'nullable|string|max:32',
            "QualificationLevel{$currentIndex}" => 'nullable|string|max:32',
            "QualificationFrom{$currentIndex}" => 'nullable|string|max:32',
            "QualificationGrade{$currentIndex}" => 'nullable|string|max:16',
            "QualificationDateComplete{$currentIndex}" => 'nullable|date',
            "QualificationImagePath{$currentIndex}" => 'nullable|image|mimes:jpg,jpeg,png|max:5048',
        ];
    
        $validated = $request->validate($rules);
    
        // handle file upload
        if ($request->hasFile("QualificationImagePath{$currentIndex}")) {
            if ($qualf->{"QualificationImagePath{$currentIndex}"} && 
                Storage::disk('public')->exists($qualf->{"QualificationImagePath{$currentIndex}"})) {
                Storage::disk('public')->delete($qualf->{"QualificationImagePath{$currentIndex}"});
            }
    
            $validated["QualificationImagePath{$currentIndex}"] = $request
                ->file("QualificationImagePath{$currentIndex}")
                ->store('qualification-files', 'public');
        }
    
        // Update only current qualification, keep others intact
        $qualf->update($validated);
    
        return redirect()
            ->route('my-bio-qualifications')
            ->with('success', "Qualification {$currentIndex} saved successfully!");
    }
    
    //3️⃣ Update qualification
    public function updateQualification(Request $request)
    {
        $userId = auth()->id();
        $totalQualifications = 4;

        $rules = [];
        for ($i = 1; $i <= $totalQualifications; $i++) {
            $rules["QualificationTitle{$i}"] = 'nullable|string|max:32';
            $rules["QualificationLevel{$i}"] = 'nullable|string|max:32';
            $rules["QualificationFrom{$i}"] = 'nullable|string|max:32';
            $rules["QualificationGrade{$i}"] = 'nullable|string|max:16';
            $rules["QualificationDateComplete{$i}"] = 'nullable|date';
            $rules["QualificationImagePath{$i}"] = 'nullable|image|mimes:jpg,jpeg,png|max:5048';
        }

        $validated = $request->validate($rules);

        $qualf = SysUserType30Attributes::where('UserID', $userId)->first();

        for ($i = 1; $i <= $totalQualifications; $i++) {
            if ($request->hasFile("QualificationImagePath{$i}")) {
                if ($qualf && isset($qualf->{"QualificationImagePath{$i}"}) && Storage::disk('public')->exists($qualf->{"QualificationImagePath{$i}"})) {
                    Storage::disk('public')->delete($qualf->{"QualificationImagePath{$i}"});
                }

                $validated["QualificationImagePath{$i}"] = $request->file("QualificationImagePath{$i}")->store('qualification-files', 'public');
            }
        }

        $qualf->update($validated);

        return redirect()
            ->route('my-bio-qualifications')
            ->with('success', 'Qualifications updated successfully!');
    }

    //4️⃣ Delete qualification
    public function deleteQualification()
    {
        $userId = auth()->id();
        $qualf = SysUserType30Attributes::where('UserID', $userId)->first();

        if ($qualf) {
            // Delete qualification images if exist
            for ($i = 1; $i <= 4; $i++) {
                $image = $qualf->{"QualificationImagePath{$i}"} ?? null;
                if ($image && Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }

                // Set qualification fields to null
                $qualf->{"QualificationTitle{$i}"} = null;
                $qualf->{"QualificationLevel{$i}"} = null;
                $qualf->{"QualificationFrom{$i}"} = null;
                $qualf->{"QualificationGrade{$i}"} = null;
                $qualf->{"QualificationDateComplete{$i}"} = null;
                $qualf->{"QualificationImagePath{$i}"} = null;
            }

            // Save all null changes
            $qualf->save();
        }

        return redirect()
            ->route('my-bio-qualifications')
            ->with('success', 'All qualifications deleted successfully!');
    }

 }
