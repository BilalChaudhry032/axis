<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;

    protected $table = 'billing_address';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
}
