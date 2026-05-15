<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeTask extends Model
{
    protected $fillable = [
        'overtime_id',
        'task_title',
        'task_description',
    ];
}