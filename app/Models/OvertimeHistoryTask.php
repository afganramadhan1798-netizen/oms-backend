<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeHistoryTask extends Model
{
    public $table = 'overtime_histories_task';

    protected $fillable = [
        'overtime_id',
        'task_title',
        'task_description',
    ];
}