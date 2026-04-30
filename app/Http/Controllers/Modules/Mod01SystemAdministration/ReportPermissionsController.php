<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\SysReportAccessPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportPermissionsController extends Controller
{

    public function index(Request $request)
    {
        $sortBy  = $request->get('sort_by', 'ID');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowed = [
            'ID',
            'ReportName',
            'ReportCells',
            'ReportStyle',
            'JMH_Super_Admin_90',
            'JMH_System_Admin_91',
            'JMH_Finance_Admin_92',
            'JMH_Regional_Admin_93',
            'JMH_National_Admin_94',
            'JMH_Group_Admin_95',
            'PRO_Group_Admin_40',
            'PRO_Group_Manager_41',
            'PRO_Group_Team_Leader_42',
            'MED_Group_Admin_20',
            'MED_Group_Manager_21',
            'MED_Group_Team_leader_22',
        ];

        if (!in_array($sortBy, $allowed)) $sortBy = 'ID';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'asc';

        $items = SysReportAccessPermissions::orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view('modules.mod-01.tm.report-access', compact(
            'items',
            'sortBy',
            'sortDir'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ReportName'  => 'required|string|max:48',
            'ReportCells' => 'required|integer|in:0,1',
            'ReportStyle' => 'required|string|max:16',

            'JMH_Super_Admin_90'     => 'nullable|integer|in:0,1',
            'JMH_System_Admin_91'   => 'nullable|integer|in:0,1',
            'JMH_Finance_Admin_92'  => 'nullable|integer|in:0,1',
            'JMH_Regional_Admin_93' => 'nullable|integer|in:0,1',
            'JMH_National_Admin_94' => 'nullable|integer|in:0,1',
            'JMH_Group_Admin_95'    => 'nullable|integer|in:0,1',

            'PRO_Group_Admin_40'        => 'nullable|integer|in:0,1',
            'PRO_Group_Manager_41'     => 'nullable|integer|in:0,1',
            'PRO_Group_Team_Leader_42' => 'nullable|integer|in:0,1',

            'MED_Group_Admin_20'        => 'nullable|integer|in:0,1',
            'MED_Group_Manager_21'     => 'nullable|integer|in:0,1',
            'MED_Group_Team_leader_22' => 'nullable|integer|in:0,1',
        ]);


        SysReportAccessPermissions::create($data);

        return back()->with('success', 'Created successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'ReportName'  => 'required|string|max:48',
            'ReportCells' => 'required|integer|in:0,1',
            'ReportStyle' => 'required|string|max:16',

            'JMH_Super_Admin_90'     => 'nullable|integer|in:0,1',
            'JMH_System_Admin_91'   => 'nullable|integer|in:0,1',
            'JMH_Finance_Admin_92'  => 'nullable|integer|in:0,1',
            'JMH_Regional_Admin_93' => 'nullable|integer|in:0,1',
            'JMH_National_Admin_94' => 'nullable|integer|in:0,1',
            'JMH_Group_Admin_95'    => 'nullable|integer|in:0,1',

            'PRO_Group_Admin_40'        => 'nullable|integer|in:0,1',
            'PRO_Group_Manager_41'     => 'nullable|integer|in:0,1',
            'PRO_Group_Team_Leader_42' => 'nullable|integer|in:0,1',

            'MED_Group_Admin_20'        => 'nullable|integer|in:0,1',
            'MED_Group_Manager_21'     => 'nullable|integer|in:0,1',
            'MED_Group_Team_leader_22' => 'nullable|integer|in:0,1',
        ]);

        SysReportAccessPermissions::findOrFail($id)->update($data);

        return back()->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        try {
            $report = SysReportAccessPermissions::findOrFail($id);
            $report->delete();

            return back()->with('success', 'Deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->with(
                    'error',
                    'Cannot delete this record because it is associated with other records.'
                );
            }

            throw $e;
        }
    }
}
