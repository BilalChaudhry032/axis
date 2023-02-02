<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $table = 'currency_exc_rate';
    public $timestamps = false;
    protected $fillable = [
        'currency',
        'to_pkr'
    ];
}
