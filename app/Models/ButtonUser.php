<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButtonUser extends Model
{
    use HasFactory;

    protected $table = 'button_user';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'button_page_id',
    ];
}
