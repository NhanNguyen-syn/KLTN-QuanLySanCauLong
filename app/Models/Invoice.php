<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = ['booking_id','invoice_no','issued_at','total'];

    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
}

