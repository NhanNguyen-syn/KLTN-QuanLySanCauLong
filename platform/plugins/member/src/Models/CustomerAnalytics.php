<?php

namespace Botble\Member\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAnalytics extends BaseModel
{
    protected $table = 'customer_analytics';

    protected $fillable = [
        'member_id',
        'rfm_recency',
        'rfm_frequency',
        'rfm_monetary',
        'segment',
        'lifetime_value',
        'last_calculated_at',
    ];

    protected $casts = [
        'rfm_monetary' => 'decimal:2',
        'lifetime_value' => 'decimal:2',
        'last_calculated_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function isVIP(): bool
    {
        return $this->segment === 'VIP';
    }

    public function isAtRisk(): bool
    {
        return $this->segment === 'At-Risk';
    }

    public function needsAttention(): bool
    {
        return in_array($this->segment, ['At-Risk', 'Churned']);
    }
}
