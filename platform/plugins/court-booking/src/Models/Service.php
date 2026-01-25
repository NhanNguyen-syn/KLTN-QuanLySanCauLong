<?php

namespace Botble\CourtBooking\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends BaseModel
{
    protected $table = 'services';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'category',
        'price',
        'cost',
        'stock',
        'track_stock',
        'unit',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'cost' => 'decimal:0',
        'stock' => 'integer',
        'track_stock' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Service types
     */
    public const TYPE_SERVICE = 'service';
    public const TYPE_PRODUCT = 'product';

    /**
     * Service categories
     */
    public const CATEGORY_BEVERAGE = 'beverage';
    public const CATEGORY_FOOD = 'food';
    public const CATEGORY_EQUIPMENT = 'equipment';
    public const CATEGORY_ACCESSORY = 'accessory';
    public const CATEGORY_STRINGING = 'stringing';
    public const CATEGORY_COACHING = 'coaching';
    public const CATEGORY_RENTAL = 'rental';
    public const CATEGORY_OTHER = 'other';

    /**
     * Get all category options for dropdown
     */
    public static function getCategoryOptions(): array
    {
        return [
            self::CATEGORY_BEVERAGE => 'Nước uống',
            self::CATEGORY_FOOD => 'Đồ ăn',
            self::CATEGORY_EQUIPMENT => 'Dụng cụ',
            self::CATEGORY_ACCESSORY => 'Phụ kiện',
            self::CATEGORY_STRINGING => 'Căng vợt',
            self::CATEGORY_COACHING => 'Huấn luyện',
            self::CATEGORY_RENTAL => 'Cho thuê',
            self::CATEGORY_OTHER => 'Khác',
        ];
    }

    /**
     * Get all type options for dropdown
     */
    public static function getTypeOptions(): array
    {
        return [
            self::TYPE_PRODUCT => 'Sản phẩm',
            self::TYPE_SERVICE => 'Dịch vụ',
        ];
    }

    /**
     * Scope: Only active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter by category
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Filter by type
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if service is in stock
     */
    public function isInStock(int $quantity = 1): bool
    {
        if (!$this->track_stock) {
            return true;
        }
        return $this->stock >= $quantity;
    }

    /**
     * Reduce stock
     */
    public function reduceStock(int $quantity = 1): bool
    {
        if (!$this->track_stock) {
            return true;
        }

        if ($this->stock < $quantity) {
            return false;
        }

        $this->decrement('stock', $quantity);
        return true;
    }

    /**
     * Increase stock
     */
    public function increaseStock(int $quantity = 1): void
    {
        if ($this->track_stock) {
            $this->increment('stock', $quantity);
        }
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price) . ' đ';
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::getCategoryOptions()[$this->category] ?? $this->category;
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute(): string
    {
        return self::getTypeOptions()[$this->type] ?? $this->type;
    }

    /**
     * Relation: BookingServices (pivot)
     */
    public function bookingServices(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    /**
     * Relation: Bookings through pivot
     */
    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(BookingList::class, 'booking_services', 'service_id', 'booking_list_id')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
    }
}
