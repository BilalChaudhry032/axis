<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    
    protected $table = 'vendor';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
}
