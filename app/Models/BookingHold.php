<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingHold extends Model
{
    protected $fillable = ['court_slot_id','user_id','expires_at'];

    public function slot(): BelongsTo { return $this->belongsTo(CourtSlot::class, 'court_slot_id'); }
}

