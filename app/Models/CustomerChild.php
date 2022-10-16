<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerChild extends Model
{
    use HasFactory;

    protected $table = 'customer_child';
    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'contact_title',
        'first_name',
        'last_name',
        'direct',
        'cell',
        'email',
        'notes',
        'active',
    ];
}
