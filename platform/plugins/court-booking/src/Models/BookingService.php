<?php

namespace Botble\CourtBooking\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingService extends BaseModel
{
    protected $table = 'booking_services';

    protected $fillable = [
        'booking_list_id',
        'service_id',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:0',
        'total_price' => 'decimal:0',
    ];

    /**
     * Auto-calculate total_price before saving
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_price = $model->quantity * $model->unit_price;
        });
    }

    /**
     * Relation: BookingList
     */
    public function bookingList(): BelongsTo
    {
        return $this->belongsTo(BookingList::class, 'booking_list_id');
    }

    /**
     * Relation: Service
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return number_format($this->total_price) . ' đ';
    }

    /**
     * Get formatted unit price
     */
    public function getFormattedUnitPriceAttribute(): string
    {
        return number_format($this->unit_price) . ' đ';
    }
}
