<?php

namespace Botble\ReceptionistPortal\Models;

use Botble\Base\Models\BaseModel;

class VipCustomer extends BaseModel
{
    protected $table = 'vip_customers';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'type',
        'discount_percent',
        'credit_limit',
        'current_debt',
        'member_since',
        'valid_until',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'credit_limit' => 'decimal:0',
        'current_debt' => 'decimal:0',
        'member_since' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * VIP types
     */
    public const TYPE_MEMBER = 'member';
    public const TYPE_VIP = 'vip';
    public const TYPE_GOLD = 'gold';
    public const TYPE_PLATINUM = 'platinum';

    /**
     * Get type options
     */
    public static function getTypeOptions(): array
    {
        return [
            self::TYPE_MEMBER => 'Thành viên',
            self::TYPE_VIP => 'VIP',
            self::TYPE_GOLD => 'Gold',
            self::TYPE_PLATINUM => 'Platinum',
        ];
    }

    /**
     * Scope: Active customers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Find by phone number
     */
    public static function findByPhone(string $phone): ?self
    {
        return static::where('phone', $phone)->first();
    }

    /**
     * Check if can add more debt
     */
    public function canAddDebt(float $amount): bool
    {
        return $this->credit_limit > 0 &&
            ($this->current_debt + $amount) <= $this->credit_limit;
    }

    /**
     * Add debt
     */
    public function addDebt(float $amount): bool
    {
        if (!$this->canAddDebt($amount)) {
            return false;
        }
        $this->increment('current_debt', $amount);
        return true;
    }

    /**
     * Pay debt
     */
    public function payDebt(float $amount): void
    {
        $this->decrement('current_debt', min($amount, $this->current_debt));
    }

    /**
     * Calculate discounted price
     */
    public function calculateDiscountedPrice(float $originalPrice): float
    {
        return $originalPrice * (1 - $this->discount_percent / 100);
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute(): string
    {
        return self::getTypeOptions()[$this->type] ?? $this->type;
    }

    /**
     * Get formatted discount
     */
    public function getFormattedDiscountAttribute(): string
    {
        return $this->discount_percent . '%';
    }

    /**
     * Get available credit
     */
    public function getAvailableCreditAttribute(): float
    {
        return max(0, $this->credit_limit - $this->current_debt);
    }
}
