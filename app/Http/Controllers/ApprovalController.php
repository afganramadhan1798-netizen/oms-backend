<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $approvals = Overtime::with(['employee', 'tasks'])
            ->when($user->role != 'human_resource', function($q) use ($user) {
              $q->where('product_manager_id', $user->id);
            }, function($q) //khusus hr
                {$q->where('status', 'approved');})
            ->latest()
            ->get()
            ->map(function ($item) use($user) {
                return [
                    'id' => $item->id,
                    'employeeName' => $item->employee->name,
                    'employeePosition' => $item->employee->position,
                    'overtime_title'=>$item->overtime_title,
                    'overtimeDate' => $item->date,
                    'startTime' => $item->start_time,
                    'endTime' => $item->end_time,
                    'duration' => $item->duration . ' Hours',
                    'status' => $this->getFinalStatus($user, $item),
                    'tasks' => $item->tasks->map(function ($task) {
                        return [
                            'name' => $task->task_title,
                            'description' => $task->task_description
                        ];
                    })
                ];
            });

        return response()->json($approvals);
    }

public function approve($id)
{
    $overtime = Overtime::findOrFail($id);

    $overtime->status = 'approved';

    $overtime->save();

    return response()->json([
        'message' => 'Reviewed by PM successfully'
    ]);
}
 public function reject($id)
{
    $overtime = Overtime::findOrFail($id);

    $overtime->status = 'declined';

    $overtime->save();

    return response()->json([
        'message' => 'Rejected successfully',
        'data' => $overtime
    ]);
}

public function hrApprove($id)
{
    $overtime = Overtime::findOrFail($id);

    if ($overtime->status !== 'approved') {
        return response()->json([
            'message' => 'PM has not reviewed this overtime yet'
        ], 400);
    }

    $overtime->update([
        'human_resource_status' => 'approved',
        'human_resource_id' => auth()->id(),
        'human_resource_reviewed_at' => now(),
    ]);

    return response()->json([
        'message' => 'Overtime approved by HR',
        'data' => $overtime
    ]);
}

public function hrReject(Request $request, $id)
{
    $overtime = Overtime::findOrFail($id);

    if ($overtime->status !== 'approved') {
        return response()->json([
            'message' => 'PM has not reviewed this overtime yet'
        ], 400);
    }

    $overtime->update([
        'human_resource_status' => 'declined',
        'human_resource_id' => auth()->id(),
        'human_resource_reviewed_at' => now(),
        'human_resource_notes' => $request->notes,
    ]);

    return response()->json([
        'message' => 'Overtime declined by HR',
        'data' => $overtime
    ]);
}

private function getFinalStatus($user, $item)
{
    // PM belum approve
    if ($user->role == 'human_resource' && $item->human_resource_status === 'pending') {
        return 'Pending';
    }

    // PM approve, HR belum review
    if (
        $user->role == 'employee' &&
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