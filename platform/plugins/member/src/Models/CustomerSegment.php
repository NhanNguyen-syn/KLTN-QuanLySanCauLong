<?php

namespace Botble\Member\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerSegment extends BaseModel
{
    protected $table = 'customer_segments';

    protected $fillable = [
        'member_id',
        'segment_type',
        'score',
        'metadata',
        'assigned_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'assigned_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function getPreference(string $key, $default = null)
    {
        return data_get($this->metadata, $key, $default);
    }

    public function setPreference(string $key, $value): void
    {
        $metadata = $this->metadata ?? [];
        data_set($metadata, $key, $value);
        $this->metadata = $metadata;
    }
}
