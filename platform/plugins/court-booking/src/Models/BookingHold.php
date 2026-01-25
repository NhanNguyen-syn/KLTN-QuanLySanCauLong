<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingHold extends Model
{
    protected $fillable = ['court_slot_id', 'user_id', 'expires_at', 'booking_type', 'priority'];

    public function slot(): BelongsTo
    {
        return $this->belongsTo(\Botble\CourtBooking\Models\CourtSlot::class, 'court_slot_id');
    }
}

