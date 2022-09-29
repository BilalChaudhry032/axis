<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    public $timestamps = false;
    protected $fillable = [
        'workorder_id',
        'payment_method_id',
        'payment_date',
        'payment_amount',
        'bank_name',
        'cheque_num',
        'cheque_date',
        'cheque_amount',
        'received'
    ];
}
