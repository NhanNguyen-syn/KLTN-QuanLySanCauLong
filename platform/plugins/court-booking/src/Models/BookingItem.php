<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingItem extends Model
{
    protected $fillable = ['booking_id','court_slot_id','price'];

    public function booking(): BelongsTo { return $this->belongsTo(\Botble\CourtBooking\Models\Booking::class); }
    public function slot(): BelongsTo { return $this->belongsTo(\Botble\CourtBooking\Models\CourtSlot::class, 'court_slot_id'); }
}

