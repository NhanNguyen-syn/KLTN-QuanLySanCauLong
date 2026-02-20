<?php

namespace Botble\AiChatbot\Models;

use Illuminate\Database\Eloquent\Model;

class ChatContext extends Model
{
    protected $table = 'chat_context';

    protected $fillable = [
        'session_id',
        'context_data',
        'expires_at',
    ];

    protected $casts = [
        'context_data' => 'array',
        'expires_at' => 'datetime',
    ];

    public function getHistory(): array
    {
        return data_get($this->context_data, 'history', []);
    }

    public function getLastIntent(): ?string
    {
        return data_get($this->context_data, 'last_intent');
    }

    public function addToHistory(array $message): void
    {
        $history = $this->getHistory();
        $history[] = $message;

        // Keep only last 5 messages
        $history = array_slice($history, -5);

        $data = $this->context_data ?? [];
        $data['history'] = $history;
        $this->context_data = $data;
        $this->save();
    }

    public function setLastIntent(string $intent, array $entities = []): void
    {
        $data = $this->context_data ?? [];
        $data['last_intent'] = $intent;
        $data['entities'] = $entities;
        $this->context_data = $data;
        $this->save();
    }
}
