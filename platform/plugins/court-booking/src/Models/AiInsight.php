<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'insight_type',
        'title',
        'description',
        'data',
        'priority',
        'is_read',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('insight_type', $type);
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
