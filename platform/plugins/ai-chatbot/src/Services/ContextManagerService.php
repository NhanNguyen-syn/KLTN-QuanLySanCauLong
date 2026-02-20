<?php

namespace Botble\AiChatbot\Services;

use Botble\AiChatbot\Models\ChatContext;
use Carbon\Carbon;

class ContextManagerService
{
    public function getOrCreateContext(string $sessionId): ChatContext
    {
        return ChatContext::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'context_data' => ['history' => []],
                'expires_at' => now()->addHours(24),
            ]
        );
    }

    public function addMessage(string $sessionId, string $role, string $content): void
    {
        $context = $this->getOrCreateContext($sessionId);

        $context->addToHistory([
            'role' => $role,
            'content' => $content,
            'time' => now()->toISOString(),
        ]);

        // Extend expiration
        $context->expires_at = now()->addHours(24);
        $context->save();
    }

    public function getHistory(string $sessionId): array
    {
        $context = ChatContext::where('session_id', $sessionId)->first();

        return $context ? $context->getHistory() : [];
    }

    public function getContextualPrompt(string $sessionId, string $currentMessage): string
    {
        $history = $this->getHistory($sessionId);

        if (empty($history)) {
            return $currentMessage;
        }

        $contextPrompt = "Lịch sử hội thoại gần đây:\n";

        foreach (array_slice($history, -3) as $msg) {
            $contextPrompt .= "{$msg['role']}: {$msg['content']}\n";
        }

        $contextPrompt .= "\nCâu hỏi hiện tại: {$currentMessage}\n";
        $contextPrompt .= "Vui lòng trả lời dựa trên ngữ cảnh trên.";

        return $contextPrompt;
    }

    public function updateIntent(string $sessionId, string $intent, array $entities = []): void
    {
        $context = $this->getOrCreateContext($sessionId);
        $context->setLastIntent($intent, $entities);
    }

    public function getLastIntent(string $sessionId): ?string
    {
        $context = ChatContext::where('session_id', $sessionId)->first();

        return $context ? $context->getLastIntent() : null;
    }

    public function clearExpiredContexts(): int
    {
        return ChatContext::where('expires_at', '<', now())->delete();
    }
}
