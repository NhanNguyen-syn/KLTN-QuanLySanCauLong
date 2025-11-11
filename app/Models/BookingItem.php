<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingItem extends Model
{
    protected $fillable = ['booking_id','court_slot_id','price'];

    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function slot(): BelongsTo { return $this->belongsTo(CourtSlot::class, 'court_slot_id'); }
}

