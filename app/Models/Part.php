<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $table = 'part';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'unit_price',
        'description'
    ];
}
