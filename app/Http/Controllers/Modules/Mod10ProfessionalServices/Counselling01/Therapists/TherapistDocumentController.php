<?php
namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TherapistDocumentController extends Controller
{
    protected function therapistPath()
    {
        return 'private/' . auth()->id();
    }

    public function index()
    {
        $files = [];
    
        // Common files (visible to all)
        $commonFiles = Storage::disk('therapy_docs')->files('common');
    
        foreach ($commonFiles as $file) {
            $files[] = [
                'name' => basename($file),
                'path' => $file,
                'type' => 'common',
            ];
        }
    
        // Private files (only current user)
        $privateFiles = Storage::disk('therapy_docs')->files($this->therapistPath());
    
        foreach ($privateFiles as $file) {
            $files[] = [
                'name' => basename($file),
                'path' => $file,
                'type' => 'private',
            ];
        }
    
        return view(
            'modules.mod-10.01-counselling.therapists.Therapists-collateral-documents',
            compact('files')
        );
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $type = $request->input('type');

        // ✅ FIXED PATH
        if ($type === 'common') {
            $path = 'common';
        } else {
            $path = $this->therapistPath();
        }

        // ✅ KEEP ORIGINAL NAME (cleaned)
        $file = $request->file('file');

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $fileName = time() . '-' . Str::slug($originalName) . '.' . $extension;

        // ensure folder exists
        Storage::disk('therapy_docs')->makeDirectory($path);

        // ✅ IMPORTANT FIX (no more encrypted names)
        Storage::disk('therapy_docs')->putFileAs($path, $file, $fileName);

        return back()->with('success', 'File uploaded');
    }

    public function download($type, $file)
    {
        if ($type === 'common') {
            $path = 'common/' . $file;
        } else {
            $path = $this->therapistPath() . '/' . $file;
        }

        if (!Storage::disk('therapy_docs')->exists($path)) {
            abort(404);
        }

        return Storage::disk('therapy_docs')->download($path);
    }

    public function delete($type, $file)
    {
        if ($type === 'common') {
            // optional: restrict later
            $path = 'common/' . $file;
        } else {
            $path = $this->therapistPath() . '/' . $file;
        }

        if (Storage::disk('therapy_docs')->exists($path)) {
            Storage::disk('therapy_docs')->delete($path);
        }

        return back()->with('success', 'File deleted');
    }
}