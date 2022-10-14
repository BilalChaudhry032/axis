<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerParent extends Model
{
    use HasFactory;

    protected $table = 'customer_parent';
    public $timestamps = false;
    protected $fillable = [
        'postal_address',
        'postal_code',
        'fax',
        'extension',
        'company_id',
        'billing_address_id',
        'country',
        'province',
        'city',
        'telephone'
    ];
}
