<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    protected $fillable = ['name','type','from_time','to_time','price','priority','active'];
}

