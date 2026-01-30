<?php

namespace Botble\CourtBooking\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookingList extends BaseModel
{
    protected $table = 'court_bookings_list';

    /**
     * @var bool
     */
    public $timestamps = true;

    protected $fillable = [
        'order_code',
        'court_id',
        'court_name',
        'date',
        'start_time',
        'end_time',
        'status',
        'customer_name',
        'contact',
        'price',
        'paid_amount',
        'notes',
        'email',
        'invoice_created_at',
        'invoice_updated_at',
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'paid_amount' => 'decimal:0',
        'date' => 'date',
    ];

    /**
     * Status constants
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Relation: Court
     */
    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    /**
     * Relation: BookingServices (pivot records)
     */
    public function bookingServices(): HasMany
    {
        return $this->hasMany(BookingService::class, 'booking_list_id');
    }

    /**
     * Relation: Services through pivot
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'booking_services', 'booking_list_id', 'service_id')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get total services price
     */
    public function getServicesTotalAttribute(): float
    {
        return (float) $this->bookingServices()->sum('total_price');
    }

    /**
     * Get grand total (court price + services)
     */
    public function getGrandTotalAttribute(): float
    {
        return (float) $this->price + $this->services_total;
    }

    /**
     * Get formatted grand total
     */
    public function getFormattedGrandTotalAttribute(): string
    {
        return number_format($this->grand_total) . ' đ';
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price) . ' đ';
    }

    /**
     * Get remaining amount to pay
     */
    public function getRemainingAmountAttribute(): float
    {
        return max(0, $this->grand_total - ($this->paid_amount ?? 0));
    }

    /**
     * Check if fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->grand_total;
    }

    /**
     * Add service to booking
     */
    public function addService(Service $service, int $quantity = 1, ?string $notes = null): BookingService
    {
        return $this->bookingServices()->create([
            'service_id' => $service->id,
            'quantity' => $quantity,
            'unit_price' => $service->price,
            'total_price' => $service->price * $quantity,
            'notes' => $notes,
        ]);
    }

    /**
     * Remove service from booking
     */
    public function removeService(int $serviceId): bool
    {
        return $this->bookingServices()->where('service_id', $serviceId)->delete() > 0;
    }
}
