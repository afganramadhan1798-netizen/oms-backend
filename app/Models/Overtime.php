<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'duration',
        'status',
        'start_time',
        'end_time',
        'product_manager_id',
    ];
    public function user ()
    {
        return $this->belongsTo (User::class);
    }

    public function tasks ()
    {
        return $this->belongsToMany (OvertimeTask::class);
    }
}
