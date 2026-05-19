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
    public function employee ()
    {
        return $this->belongsTo (User::class, 'employee_id');
    }

    public function tasks ()
    {
        return $this->hasMany (OvertimeTask::class);
    }
}