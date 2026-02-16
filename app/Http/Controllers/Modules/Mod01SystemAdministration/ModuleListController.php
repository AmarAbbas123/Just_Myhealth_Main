<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\SysModuleList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleListController extends Controller
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
            'ModuleDesc',
            'ModuleStatus',
        ];

        if (!in_array($sortBy, $allowed)) $sortBy = 'ID';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'asc';

        $items = SysModuleList::orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view('modules.mod-01.tm.module-list', compact(
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
            'ModuleDesc'    => 'required|string|max:32',
            'ModuleStatus'  => 'required|in:Active,Disabled,Testing,Development',
        ]);

        SysModuleList::create($data);

        return back()->with('success', 'Created successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'ModuleRef'     => 'required|integer|min:0|max:99',
            'ModuleSubRef'  => 'required|integer|min:0|max:99',
            'ModuleFull'    => 'required|string|max:4',
            'ModuleDesc'    => 'required|string|max:32',
            'ModuleStatus'  => 'required|in:Active,Disabled,Testing,Development',
        ]);

        SysModuleList::findOrFail($id)->update($data);

        return back()->with('success', 'Updated successfully');
    }



    public function destroy($id)
    {
        try {
            $module = SysModuleList::findOrFail($id);
            $module->delete();

            return back()->with('success', 'Module deleted successfully.');
        } catch (QueryException $e) {
            // MySQL FK constraint error code
            if ($e->getCode() == 23000) {
                return back()->with(
                    'error',
                    'Cannot delete this module because it is associated with other records.'
                );
            }

            throw $e; // rethrow unexpected errors
        }
    }
}
