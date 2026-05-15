<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Overtime;
use App\Models\OvertimeTask;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $queryOvertime = Overtime::select('overtimes.*', 'users.name AS user_name', 'users.position', 'pm.name AS pm_name')
            ->when($user->role == 'employee', function($q) use($user) {
                $q->join('users', 'users.id', 'overtimes.employee_id')
                    ->leftJoin('users as pm', 'pm.id', '=', 'overtimes.product_manager_id')
                    ->where('overtimes.employee_id', $user->id);
            })
            ->when($user->role == 'product_manager', function($q) use($user) {
                $q->join('users', 'users.id', 'overtimes.product_manager_id')
                    ->where('overtimes.product_manager_id', $user->id);
            });

        $overtime = $queryOvertime->get()->map( function($item) {
            $overtimeTask = OvertimeTask::select('task_title', 'task_description')->where('overtime_id', $item->id)->get();
            $item->tasks = implode("<br />", $overtimeTask->pluck('task_title')->toArray());
            $item->detail_task = $overtimeTask;
            return $item;
        });

        $totalHours = $queryOvertime->sum('duration');

        $totalSubmission = $queryOvertime->count();

        $totalApproved = $queryOvertime
            ->where('status', 'approved')
            ->count();

        $totalPending = $queryOvertime
            ->where('status', 'pending')
            ->count();

        $totalDeclined = $queryOvertime
            ->where('status', 'declined')
            ->count();

        return response()->json([
            'summary' => [
                'totalHours' => $totalHours,
                'totalSubmission' => $totalSubmission,
                'totalApproved' => $totalApproved,
                'totalPending' => $totalPending,
                'totalDeclined' => $totalDeclined
            ],
            'overtime' => $overtime
        ]);
    }
}