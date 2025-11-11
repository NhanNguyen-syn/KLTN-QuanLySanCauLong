<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    protected $fillable = ['name','type','from_time','to_time','price','priority','active'];
}

