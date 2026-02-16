<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration;

use App\Http\Controllers\Controller;
use App\Models\SysConfiguredAutoEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SysConfigAutoEmailsController extends Controller
{

    public function index(Request $request)
    {
        $sortBy  = $request->get('sort_by', 'ID');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowed = [
            'ID',
            'ModuleRef',
            'ModuleSubRef',
            'ModuleFull',
            'EmailSubRef',
            'EmailShortDesc',
            'EamilLongDesc',
        ];

        if (!in_array($sortBy, $allowed)) $sortBy = 'ID';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'asc';

        $items = SysConfiguredAutoEmails::orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view('modules.mod-01.tm.auto-emails', compact(
            'items',
            'sortBy',
            'sortDir'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ModuleRef'     => 'required|integer|min:0|max:99',
            'ModuleSubRef'  => 'required|integer|min:0|max:99',
            'ModuleFull'    => 'required|string|max:4',
            'EmailSubRef'      => 'required|string|max:3',
            'EmailShortDesc'   => 'required|string|max:32',
            'EamilLongDesc'    => 'required|string|max:255',
        ]);

        SysConfiguredAutoEmails::create($data);

        return back()->with('success', 'Created successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'ModuleRef'     => 'required|integer|min:0|max:99',
            'ModuleSubRef'  => 'required|integer|min:0|max:99',
            'ModuleFull'    => 'required|string|max:4',
            'EmailSubRef'      => 'required|string|max:3',
            'EmailShortDesc'   => 'required|string|max:32',
            'EamilLongDesc'    => 'required|string|max:255',
        ]);

        SysConfiguredAutoEmails::findOrFail($id)->update($data);

        return back()->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        $autoEmail = SysConfiguredAutoEmails::findOrFail($id);

        // Prevent delete if used
        if ($autoEmail->sentEmails()->exists()) {
            return back()->with(
                'error',
                'Cannot delete this record because it is already associated with sent emails.'
            );
        }

        // HARD DELETE
        $autoEmail->delete();

        return back()->with('success', 'Deleted successfully');
    }
}
