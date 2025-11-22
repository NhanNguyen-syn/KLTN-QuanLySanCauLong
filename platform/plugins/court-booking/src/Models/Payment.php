<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['booking_id','provider','amount','status','transaction_ref','meta'];
    protected $casts = ['meta' => 'array'];

    public function booking(): BelongsTo { return $this->belongsTo(\Botble\CourtBooking\Models\Booking::class); }
}

