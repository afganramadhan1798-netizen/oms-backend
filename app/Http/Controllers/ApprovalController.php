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
            ->when($user->role != 'human_resource', function($q) {
              $q->where('product_manager_id', $user->id);
            })
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'employeeName' => $item->employee->name,
                    'employeePosition' => $item->employee->position,
                    'overtime_title'=>$item->overtime_title,
                    'overtimeDate' => $item->date,
                    'startTime' => $item->start_time,
                    'endTime' => $item->end_time,
                    'duration' => $item->duration . ' Hours',
                    'status' => ucfirst($item->status),
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
            'message' => 'Approved successfully'
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
}
