<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderLabor extends Model
{
    use HasFactory;

    protected $table = 'workorder_labor';
    public $timestamps = false;
    protected $fillable = [
        'workorder_id',
        'employee_id',
        'billable_hours',
        'hourly_rate',
        'comments'
    ];
}
