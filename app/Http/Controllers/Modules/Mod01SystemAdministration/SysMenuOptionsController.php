<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration;

use App\Http\Controllers\Controller;
use App\Models\SysMenuDisplayOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SysMenuOptionsController extends Controller
{

    public function index(Request $request)
    {
        $sortBy  = $request->get('sort_by', 'ID');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowed = [
            'ID',
            'ParentID',
            'DisplayName',
            'MainPaneID',
            'MainPaneLabel',
            'TileText',
            'Grouping',
            'MenuURL',
            'ImagePath',
            '1',
            '10',
            '30',
            '31',
            '32',
            '90',
            '91',
        ];

        if (!in_array($sortBy, $allowed)) $sortBy = 'ID';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'asc';

        $items = SysMenuDisplayOption::orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view(
            'modules.mod-01.tm.menu-display-options',
            compact('items', 'sortBy', 'sortDir')
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ParentID'        => 'nullable|integer|min:0|max:9999',
            'DisplayName'     => 'nullable|string|max:255',
            'MainPaneID'      => 'nullable|integer|min:0|max:9999',
            'MainPaneLabel'   => 'nullable|string|max:48',
            'TileText'        => 'nullable|string|max:2048',
            'Grouping'        => 'nullable|string|max:24',
            '1'               => 'nullable|integer|in:0,1',
            '10'              => 'nullable|integer|in:0,1',
            '30'              => 'nullable|integer|in:0,1',
            '31'              => 'nullable|integer|in:0,1',
            '32'              => 'nullable|integer|in:0,1',
            '90'              => 'nullable|integer|in:0,1',
            '91'              => 'nullable|integer|in:0,1',
            'MenuURL'         => 'nullable|string|max:500',
            'ImagePath'       => 'nullable|string|max:255',
        ]);


        SysMenuDisplayOption::create($data);

        return back()->with('success', 'Menu option created successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'ParentID'        => 'nullable|integer|min:0|max:9999',
            'DisplayName'     => 'nullable|string|max:255',
            'MainPaneID'      => 'nullable|integer|min:0|max:9999',
            'MainPaneLabel'   => 'nullable|string|max:48',
            'TileText'        => 'nullable|string|max:2048',
            'Grouping'        => 'nullable|string|max:24',
            '1'               => 'nullable|integer|in:0,1',
            '10'              => 'nullable|integer|in:0,1',
            '30'              => 'nullable|integer|in:0,1',
            '31'              => 'nullable|integer|in:0,1',
            '32'              => 'nullable|integer|in:0,1',
            '90'              => 'nullable|integer|in:0,1',
            '91'              => 'nullable|integer|in:0,1',
            'MenuURL'         => 'nullable|string|max:500',
            'ImagePath'       => 'nullable|string|max:255',
        ]);

        SysMenuDisplayOption::findOrFail($id)->update($data);

        return back()->with('success', 'Menu option updated successfully');
    }

    public function destroy($id)
    {
        SysMenuDisplayOption::findOrFail($id)->delete();

        return back()->with('success', 'Menu option deleted successfully');
    }
}
