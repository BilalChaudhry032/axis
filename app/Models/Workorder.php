<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerParent;

class Workorder extends Model
{
    use HasFactory;

    protected $table = 'workorder';

    public function customerParent() {
        return $this->hasOne(CustomerParent::class);
    }

    // public function searchWorkOrder($query, array $filters) {
    //     dd($filters['search']);
    // }

}