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

        // ✅ ensure therapist folders exist
        foreach ($this->defaultFolders() as $folder) {
            Storage::disk('therapy_docs')->makeDirectory(
                $this->therapistPath() . '/' . $folder
            );
        }

        // Common files (visible to all)
        $commonFiles = Storage::disk('therapy_docs')->files('common');

        foreach ($commonFiles as $file) {
            $files[] = [
                'name' => basename($file),
                'path' => $file,
                'type' => 'common',
                'folder' => null,
            ];
        }

        // Private files (only current user)
        $privateFiles = Storage::disk('therapy_docs')->files($this->therapistPath());

        // Private files (loop folders)
        foreach ($this->defaultFolders() as $folder) {
            $folderPath = $this->therapistPath() . '/' . $folder;

            $folderFiles = Storage::disk('therapy_docs')->files($folderPath);

            foreach ($folderFiles as $file) {
                $files[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'type' => 'private',
                    'folder' => $folder,
                ];
            }
        }

        return view(
            'modules.mod-10.01-counselling.therapists.Therapists-collateral-documents',
            compact('files')
        );
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'type' => 'required|in:private,common',
            'folder' => 'nullable|string'
        ]);

        $type = $request->input('type');
        $folder = $request->input('folder');

        // ✅ FIXED PATH
        if ($type === 'common') {
            $path = 'common';
        } else {
            // ✅ force valid folder
            if (!in_array($folder, $this->defaultFolders())) {
                $folder = 'Folder01';
            }

            $path = $this->therapistPath() . '/' . $folder;
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
            // find file in folders
            foreach ($this->defaultFolders() as $folder) {
                $tryPath = $this->therapistPath() . '/' . $folder . '/' . $file;

                if (Storage::disk('therapy_docs')->exists($tryPath)) {
                    return Storage::disk('therapy_docs')->download($tryPath);
                }
            }

            abort(404);
        }

        return Storage::disk('therapy_docs')->download($path);
    }

    public function delete($type, $file)
    {
        if ($type === 'common') {
            $path = 'common/' . $file;

            if (Storage::disk('therapy_docs')->exists($path)) {
                Storage::disk('therapy_docs')->delete($path);
            }
        } else {
            foreach ($this->defaultFolders() as $folder) {
                $tryPath = $this->therapistPath() . '/' . $folder . '/' . $file;

                if (Storage::disk('therapy_docs')->exists($tryPath)) {
                    Storage::disk('therapy_docs')->delete($tryPath);
                    break;
                }
            }
        }

        return back()->with('success', 'File deleted');
    }

    protected function defaultFolders()
    {
        return [
            'Folder01',
            'Folder02',
            'Folder03',
            'Folder04',
            'Folder05',
            'Folder06',
            'Folder07',
            'Folder08',
        ];
    }
}
