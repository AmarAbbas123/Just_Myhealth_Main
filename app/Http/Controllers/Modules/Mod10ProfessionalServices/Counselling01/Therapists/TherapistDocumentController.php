<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TherapistDocumentController extends Controller
{
    protected function privateBasePath()
    {
        return 'private/' . auth()->id();
    }
    
    protected function commonBasePath()
    {
        return 'common/' . auth()->id();
    }


    public function index()
    {
        $files = [];
    
        foreach ($this->folders() as $folder) {
    
            // COMMON (user scoped now)
            $commonPath = $this->commonBasePath() . '/' . $folder;
            if (Storage::disk('therapy_docs')->exists($commonPath)) {
                foreach (Storage::disk('therapy_docs')->files($commonPath) as $file) {
                    $files[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'type' => 'common',
                        'folder' => $folder,
                    ];
                }
            }
    
            // PRIVATE
            $privatePath = $this->privateBasePath() . '/' . $folder;
            if (Storage::disk('therapy_docs')->exists($privatePath)) {
                foreach (Storage::disk('therapy_docs')->files($privatePath) as $file) {
                    $files[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'type' => 'private',
                        'folder' => $folder,
                    ];
                }
            }
        }
    
        return view(
            'modules.mod-10.01-counselling.therapists.Therapists-collateral-documents',
            [
                'files' => $files,
                'folders' => $this->folders()
            ]
        );
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'type' => 'required|in:private,common',
            'folder' => 'required'
        ]);
    
        $folder = $request->input('folder');
    
        if ($request->type === 'common') {
            $path = $this->commonBasePath() . '/' . $folder;
        } else {
            $path = $this->privateBasePath() . '/' . $folder;
        }
    
        $file = $request->file('file');
    
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
    
        $fileName = time() . '-' . Str::slug($originalName) . '.' . $extension;
    
        Storage::disk('therapy_docs')->makeDirectory($path);
        Storage::disk('therapy_docs')->putFileAs($path, $file, $fileName);
    
        return back()->with('success', 'File uploaded');
    }

    public function download($type, $folder, $file)
    {
        if ($type === 'common') {
            $path = $this->commonBasePath() . '/' . $folder . '/' . $file;
        } else {
            $path = $this->privateBasePath() . '/' . $folder . '/' . $file;
        }
    
        abort_unless(Storage::disk('therapy_docs')->exists($path), 404);
    
        return Storage::disk('therapy_docs')->download($path);
    }

    public function delete($type, $folder, $file)
    {
        if ($type === 'common') {
            $path = $this->commonBasePath() . '/' . $folder . '/' . $file;
        } else {
            $path = $this->privateBasePath() . '/' . $folder . '/' . $file;
        }
    
        if (Storage::disk('therapy_docs')->exists($path)) {
            Storage::disk('therapy_docs')->delete($path);
        }
    
        return back()->with('success', 'File deleted');
    }

    protected function folders()
{
    return collect(range(1, 8))->map(fn($i) => 'Folder' . str_pad($i, 2, '0', STR_PAD_LEFT));
}

}
