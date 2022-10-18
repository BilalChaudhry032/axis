<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderFile extends Model
{
    use HasFactory;

    protected $table = 'workorder_file';
    public $timestamps = false;
    protected $fillable = [
        'workorder_id',
        'file_name'
    ];
}
