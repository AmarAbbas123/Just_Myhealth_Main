<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SysUserType30Attributes;

class IdRegistrationController extends Controller
{
    // --------------------------------------------------------------
    // 1️⃣ Show Blade Page
    // --------------------------------------------------------------
    public function counselorId()
    {
        return view('modules.mod-10.01-counselling.therapists.my-bio.id-registration');
    }

    // --------------------------------------------------------------
    // 2️⃣ Fetch all uploaded documents
    // --------------------------------------------------------------
    public function fetchDocuments()
    {
        $userId = Auth::id();
        $user = SysUserType30Attributes::where('UserID', $userId)->first();

        $documents = [
            [
                'key' => 'VerificationPassportImagePath',
                'doc_type' => 'Valid Passport (Government ID)',
                'document' => $user->VerificationPassportImagePath ?? null
            ],
            [
                'key' => 'VerificationBACPCardImagePath',
                'doc_type' => 'National BACP Membership',
                'document' => $user->VerificationBACPCardImagePath ?? null
            ],
            [
                'key' => 'VerificationLiabilityInsuranceImagePath',
                'doc_type' => '3rd Party Liability Insurance',
                'document' => $user->VerificationLiabilityInsuranceImagePath ?? null
            ],
            [
                'key' => 'VerificationDBSImagePath',
                'doc_type' => 'DBS (Disclosure and Barring Service Check)',
                'document' => $user->VerificationDBSImagePath ?? null
            ],
        ];

        return response()->json($documents);
    }

    // --------------------------------------------------------------
    // 3️⃣ Store a new document
    // --------------------------------------------------------------
    public function storeDocument(Request $request)
    {
        $request->validate([
            'doc_key' => 'required|string',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = SysUserType30Attributes::where('UserID', Auth::id())->firstOrFail();
        $column = $request->doc_key;

        // delete previous file if exists
        if ($user->$column) {
            Storage::delete($user->$column);
        }

        $path = $request->file('document')->store('documents', 'public');

        // store REAL path, NOT URL
        $user->$column = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'path' => Storage::url($user->$column)
        ]);
    }


    // --------------------------------------------------------------
    // 4️⃣ Update existing document (re-upload)
    // --------------------------------------------------------------
    public function updateDocument(Request $request)
    {
        $request->validate([
            'doc_key' => 'required|string',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = SysUserType30Attributes::where('UserID', Auth::id())->firstOrFail();
        $column = $request->doc_key;

        // delete previous stored file
        if ($user->$column) {
            Storage::delete($user->$column);
        }

        $path = $request->file('document')->store('documents', 'public');

        $user->$column = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'path' => Storage::url($user->$column)
        ]);
    }


    // --------------------------------------------------------------
    // 5️⃣ Delete document
    // --------------------------------------------------------------
    public function deleteDocument($type)
    {
        $user = SysUserType30Attributes::where('UserID', Auth::id())->firstOrFail();

        // remove file from storage
        if ($user->$type) {
            Storage::delete($user->$type);
        }

        // set db to null
        $user->$type = null;
        $user->save();

        return response()->json(['success' => true]);
    }
}
