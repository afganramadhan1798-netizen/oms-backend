<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\OvertimeTask;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormController extends Controller
{
    public function submit(Request $request)
{
    $request->validate([
        'overtime_title' => 'required|string|max:255',
        'date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'product_manager_id' => 'required',

        'detail_task' => 'required|array|min:1',
        'detail_task.*.task_title' => 'required',
        'detail_task.*.task_description' => 'required',
    ]);

    $start = Carbon::parse($request->start_time);
    $end = Carbon::parse($request->end_time);

    if ($end->lessThanOrEqualTo($start)) {
        $end->addDay();
    }

    $duration = $start->diffInHours($end);

    $overtime = Overtime::create([
        'employee_id' => $request->user()->id,
        'product_manager_id' => $request->product_manager_id,
        'overtime_title' => $request->overtime_title,
        'date' => $request->date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'duration' => $duration,
        'status' => 'pending'
    ]);

    foreach ($request->detail_task as $task) {
        $overtime->tasks()->create([
            'task_title' => $task['task_title'],
            'task_description' => $task['task_description'],
        ]);
    }

    return response()->json([
        'message' => 'Form submitted successfully'
    ], 201);
}

public function resubmit(Request $request, $id)
{
    $overtime = Overtime::findOrFail($id);

    // hanya overtime declined yang bisa diedit
    if ($overtime->human_resource_status !== 'declined') {
        return response()->json([
            'message' => 'This overtime cannot be edited'
        ], 400);
    }

    // validation
    $request->validate([
        'overtime_title' => 'required',
        'date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',

        'detail_task' => 'required|array|min:1',
        'detail_task.*.task_title' => 'required',
        'detail_task.*.task_description' => 'required',
    ]);
    $start = Carbon::parse($request->start_time);
    $end = Carbon::parse($request->end_time);

    if ($end->lessThanOrEqualTo($start)) {
        $end->addDay();
    }

    $duration = $start->diffInHours($end);
    // update overtime
    $overtime->update([
        'overtime_title' => $request->overtime_title,
        'date' => $request->date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'duration' => $duration,

        // reset approval flow
        'status' => 'pending',
        'human_resource_status' => 'pending',
        'human_resource_id' => null,
        'human_resource_reviewed_at' => null,
        'human_resource_notes' => null,
    ]);

    // delete old tasks
    $overtime->tasks()->delete();

    // create new tasks
    foreach ($request->detail_task as $task) {
        $overtime->tasks()->create([
            'task_title' => $task['task_title'],
            'task_description' => $task['task_description'],
        ]);
    }

    return response()->json([
        'message' => 'Overtime resubmitted successfully',
        'data' => $overtime->load('tasks')
    ]);
}

public function show($id)
{
    $overtime = Overtime::with('tasks')->findOrFail($id);

    return response()->json([
        'data' => $overtime
    ]);
}
}