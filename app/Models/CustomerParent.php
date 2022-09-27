<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerParent extends Model
{
    use HasFactory;

    protected $table = 'customer_parent';
    public $timestamps = false;
    // protected $fillable = [
    //     'name'
    // ];
}
