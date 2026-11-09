<?php

namespace App\Http\Controllers;

use App\Models\OvertimeHistory;
use App\Models\OvertimeHistoryTask;

class OvertimeHistoryController extends Controller
{
    public function index()
    {
        $histories = OvertimeHistory::select('overtime_histories.*', 'users.name AS employee_name', 'users.position AS employee_position')
            ->join('overtimes', 'overtimes.id', '=', 'overtime_histories.overtime_id')
            ->join('users', 'users.id', '=', 'overtimes.employee_id')
            ->with('tasks')->latest()->get()->unique('overtime_id')->values();
        $historyOvertimeId = $histories->pluck('overtime_id');
        $historyId = $histories->pluck('id');

        $historiesDetail = OvertimeHistory::select('overtime_histories.*', 'users.name AS hr_name')
            ->join('users', 'users.id', '=', 'overtime_histories.actor_id')
            ->whereIn('overtime_id', $historyOvertimeId)->orderBy('created_at', 'ASC')
            ->get()->groupBy('overtime_id');

        $histories = $histories->map( function($item) use($historiesDetail) {
            if (isset($historiesDetail[ $item->overtime_id ])) {
                $item->histories = $historiesDetail[ $item->overtime_id ];
            } else {
                $item->histories = [];
            }

            // $item->tasks = $historiesTask;
            return $item;
        });

        return response()->json($histories);
    }
}