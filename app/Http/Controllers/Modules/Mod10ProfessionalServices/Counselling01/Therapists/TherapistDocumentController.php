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

            $slug = $this->folderSlug($folder);

            // COMMON
            $commonPath = 'common/' . auth()->id() . '/' . $slug;
            if (Storage::disk('therapy_docs')->exists($commonPath)) {
                foreach (Storage::disk('therapy_docs')->files($commonPath) as $file) {
                    $files[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'type' => 'common',
                        'folder' => $folder, // show real name
                        'folder_slug' => $slug,
                    ];
                }
            }

            // PRIVATE
            $privatePath = 'private/' . auth()->id() . '/' . $slug;
            if (Storage::disk('therapy_docs')->exists($privatePath)) {
                foreach (Storage::disk('therapy_docs')->files($privatePath) as $file) {
                    $files[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'type' => 'private',
                        'folder' => $folder,
                        'folder_slug' => $slug,
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

        $folderName = $request->input('folder');
        $folderSlug = $this->folderSlug($folderName);

        // base path
        if ($request->type === 'common') {
            $basePath = 'common/' . auth()->id();
        } else {
            $basePath = 'private/' . auth()->id();
        }

        $path = $basePath . '/' . $folderSlug;

        $file = $request->file('file');

        // ✔ KEEP ORIGINAL NAME ONLY
        $fileName = $file->getClientOriginalName();

        // ✔ DUPLICATE CHECK
        if (Storage::disk('therapy_docs')->exists($path . '/' . $fileName)) {
            return back()->with('error', 'File already exists in this folder');
        }

        Storage::disk('therapy_docs')->makeDirectory($path);
        Storage::disk('therapy_docs')->putFileAs($path, $file, $fileName);

        return back()->with('success', 'File uploaded');
    }

    public function download($type, $folder, $file)
    {
        $slug = $this->folderSlug($folder);
    
        $base = $type === 'common'
            ? 'common/' . auth()->id()
            : 'private/' . auth()->id();
    
        $path = $base . '/' . $slug . '/' . $file;
    
        abort_unless(Storage::disk('therapy_docs')->exists($path), 404);
    
        return Storage::disk('therapy_docs')->download($path);
    }

    public function delete($type, $folder, $file)
    {
        $slug = $this->folderSlug($folder);
    
        $base = $type === 'common'
            ? 'common/' . auth()->id()
            : 'private/' . auth()->id();
    
        $path = $base . '/' . $slug . '/' . $file;
    
        if (Storage::disk('therapy_docs')->exists($path)) {
            Storage::disk('therapy_docs')->delete($path);
        }
    
        return back()->with('success', 'File deleted');
    }

    protected function folderSlug($folder)
    {
        return Str::slug($folder); // e.g. bereavement-losses
    }

    protected function folders()
    {
        return [
            'Bereavement / Losses',
            'Building self Esteem',
            'CBT (Cognitive Behavioral Therapy)',
            'Children/Parent',
            'Coping with triggers',
            'Depression',
            'Discrimination',
            'Mindfulness',
            'Motivation',
            'Narcissistic Behavior',
            'Panic attack / attack',
            'Psychological Safety Mediation',
            'Relationship',
            'Self Reflection',
            'Solution Focus',
            'Visualization',
        ];
    }
}
