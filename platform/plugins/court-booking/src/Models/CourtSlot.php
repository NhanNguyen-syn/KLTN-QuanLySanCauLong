<?php

namespace Botble\CourtBooking\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourtSlot extends BaseModel
{
    protected $table = 'court_slots';

    protected $fillable = [
        'court_id',
        'start_at',
        'end_at',
        'status',
        'base_price',
        'member_price',
        'applied_rule_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    public function bookingItems(): HasMany
    {
        return $this->hasMany(BookingItem::class, 'court_slot_id');
    }

    // Helper method to get the booking associated with this slot
    public function getBooking()
    {
        $bookingItem = $this->bookingItems()->with('booking.user')->first();
        return $bookingItem ? $bookingItem->booking : null;
    }
}

