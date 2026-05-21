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
            'tasks' => 'required|array'
        ]);

        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);

        if ($end->lessThan($start)) {
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

        foreach ($request->tasks as $task) {
            OvertimeTask::create([
                'overtime_id' => $overtime->id,
                'task_title' => $task['name'],
                'task_description' => $task['description']
            ]);
        }

        return response()->json([
            'message' => 'Form submitted successfully'
        ], 201);
    }
}
