<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderPart extends Model
{
    use HasFactory;

    protected $table = 'workorder_part';
    public $timestamps = false;
    // protected $fillable = [
    //     'name'
    // ];
}
