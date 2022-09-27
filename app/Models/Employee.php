<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    public $timestamps = false;
    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'work_phone',
        'extension',
        'email',
        'billing_rate'
    ];
}
