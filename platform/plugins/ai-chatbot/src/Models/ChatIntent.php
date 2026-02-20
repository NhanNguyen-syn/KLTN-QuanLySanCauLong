<?php

namespace Botble\AiChatbot\Models;

use Illuminate\Database\Eloquent\Model;

class ChatIntent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'message',
        'detected_intent',
        'confidence',
        'entities',
        'created_at',
    ];

    protected $casts = [
        'entities' => 'array',
        'confidence' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function isHighConfidence(): bool
    {
        return $this->confidence >= 70;
    }

    public function scopeBySession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeByIntent($query, string $intent)
    {
        return $query->where('detected_intent', $intent);
    }
}
