<?php

namespace App\Http\Controllers;

use App\Models\OvertimeHistory;

class OvertimeHistoryController extends Controller
{
    public function index()
    {
        $histories = OvertimeHistory::latest()->get()->unique('overtime_id')->values();
        $historyId = $histories->pluck('overtime_id');
        $historiesDetail = OvertimeHistory::whereIn('overtime_id', $historyId)->orderBy('created_at', 'ASC')
            ->get()->groupBy('overtime_id');

        $histories = $histories->map( function($item) use($historiesDetail) {
            if (isset($historiesDetail[ $item->overtime_id ])) {
                $item->histories = $historiesDetail[ $item->overtime_id ]->filter( fn($child) => $child->id != $item->id);
            } else {
                $item->histories = [];
            }
            return $item;
        });

        return response()->json($histories);
    }
}