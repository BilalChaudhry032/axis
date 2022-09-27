<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerParent;

class Workorder extends Model
{
    use HasFactory;

    protected $table = 'workorder';
    public $timestamps = false;
    protected $fillable = [
        'date_received',
        'po_num',
        'reference_num',
        'branch',
        'country',
        'serial_num',
        'problem_desc',
        'child_id',
        'report_name',
        'discount',
        'sales_tax_rate',
        'financial',
        'hardcopy_delivered'
    ];

}