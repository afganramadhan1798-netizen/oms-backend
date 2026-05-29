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
        'overtime_title',
        'human_resource_status',
        'human_resource_id',
        'human_resource_reviewed_at',
        'human_resource_notes',
    ];
    public function employee ()
    {
        return $this->belongsTo (User::class, 'employee_id');
    }

    public function tasks ()
    {
        return $this->hasMany (OvertimeTask::class);
    }

    public function overtime()
    {
        return $this->belongsTo(Overtime::class);
    }

    public function histories()
    {
        return $this->hasMany(OvertimeHistory::class);
    }
}
