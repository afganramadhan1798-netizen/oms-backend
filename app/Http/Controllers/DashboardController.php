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

    $baseQuery = Overtime::select(
        'overtimes.*',
        'users.name AS user_name',
        'users.position',
        'pm.name AS pm_name'
    )
    ->join('users', 'users.id', '=', 'overtimes.employee_id')
    ->leftJoin('users as pm', 'pm.id', '=', 'overtimes.product_manager_id')
    ->where('overtimes.employee_id', $user->id);

    // if ($user->role == 'employee') {
    //     $baseQuery->where('overtimes.employee_id', $user->id);
    // }

    // if ($user->role == 'product_manager') {
    //     $baseQuery->where('overtimes.product_manager_id', $user->id);
    // }

    $overtime = (clone $baseQuery)->get()->map(function ($item) {
        $overtimeTask = OvertimeTask::select('task_title', 'task_description')
            ->where('overtime_id', $item->id)
            ->get();

        $item->tasks = implode("<br />", $overtimeTask->pluck('task_title')->toArray());
        $item->detail_task = $overtimeTask;
        $item->status = $this->getFinalStatus($item);

        return $item;
    });

    $totalHours = (clone $baseQuery)->sum('duration');
    $totalSubmission = (clone $baseQuery)->count();
    $totalApproved = (clone $baseQuery)->where('overtimes.status', 'approved')->count();
    $totalPending = (clone $baseQuery)->where('overtimes.status', 'pending')->count();
    $totalDeclined = (clone $baseQuery)->where('overtimes.status', 'declined')->count();

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

private function getFinalStatus($item)
{
    // PM belum approve
    if ($item->status === 'pending') {
        return 'Pending';
    }

    // PM approve, HR belum review
    if (
        $item->status === 'approved' &&
        $item->human_resource_status === 'pending'
    ) {
        return 'Reviewed';
    }

    // HR approve
    if ($item->human_resource_status === 'approved') {
        return 'Approved';
    }

    // HR reject
    if ($item->human_resource_status === 'declined') {
        return 'Declined';
    }

    return ucfirst($item->status);
}
}
