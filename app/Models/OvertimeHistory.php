<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeHistory extends Model
{
    protected $fillable = [
        'overtime_id',
        'overtime_title',
        'date',
        'start_time',
        'end_time',
        'duration',
        'actor_id',
        'action',
        'notes',
        'status_before',
        'status_after',
    ];

    public function overtime()
    {
        return $this->belongsTo(Overtime::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
