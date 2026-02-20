<?php

namespace Botble\AiChatbot\Services;

use Botble\AiChatbot\Models\ChatContext;
use Botble\AiChatbot\Models\ChatIntent;
use Carbon\Carbon;

class IntentDetectionService
{
    // Intent patterns - simple keyword matching
    const PATTERNS = [
        'booking' => [
            'keywords' => ['đặt sân', 'book', 'booking', 'thuê sân', 'đặt ngay', 'giữ sân'],
            'entities' => ['time', 'date', 'court'],
        ],
        'faq' => [
            'keywords' => ['giá', 'bao nhiêu', 'làm sao', 'thế nào', 'có', 'không', '?'],
            'entities' => [],
        ],
        'complaint' => [
            'keywords' => ['tệ', 'kém', 'không hài lòng', 'khiếu nại', 'phàn nàn', 'không tốt'],
            'entities' => [],
        ],
    ];

    public function detectIntent(string $message, string $sessionId): ChatIntent
    {
        $message = mb_strtolower($message);
        $detectedIntent = 'other';
        $confidence = 0;
        $entities = [];

        // Check each pattern
        foreach (self::PATTERNS as $intent => $pattern) {
            $matchCount = 0;

            foreach ($pattern['keywords'] as $keyword) {
                if (mb_strpos($message, $keyword) !== false) {
                    $matchCount++;
                }
            }

            $currentConfidence = ($matchCount / max(count($pattern['keywords']), 1)) * 100;

            if ($currentConfidence > $confidence) {
                $confidence = $currentConfidence;
                $detectedIntent = $intent;
                $entities = $this->extractEntities($message, $pattern['entities']);
            }
        }

        // Save intent
        $intent = ChatIntent::create([
            'session_id' => $sessionId,
            'message' => $message,
            'detected_intent' => $detectedIntent,
            'confidence' => round($confidence, 2),
            'entities' => $entities,
            'created_at' => now(),
        ]);

        return $intent;
    }

    protected function extractEntities(string $message, array $entityTypes): array
    {
        $entities = [];

        foreach ($entityTypes as $type) {
            switch ($type) {
                case 'time':
                    // Extract time patterns (16:00, 4pm, 16h)
                    if (preg_match('/(\d{1,2})[h:]\s*(\d{0,2})/', $message, $matches)) {
                        $entities['time'] = $matches[0];
                    }
                    break;

                case 'date':
                    // Extract date patterns
                    if (preg_match('/(\d{1,2})[\/-](\d{1,2})/', $message, $matches)) {
                        $entities['date'] = $matches[0];
                    } elseif (mb_strpos($message, 'hôm nay') !== false) {
                        $entities['date'] = 'today';
                    } elseif (mb_strpos($message, 'ngày mai') !== false) {
                        $entities['date'] = 'tomorrow';
                    }
                    break;

                case 'court':
                    // Extract court numbers
                    if (preg_match('/sân\s*(\d+)/', $message, $matches)) {
                        $entities['court'] = $matches[1];
                    }
                    break;
            }
        }

        return $entities;
    }

    public function analyzeSentiment(string $message): array
    {
        $message = mb_strtolower($message);

        $positiveWords = ['tốt', 'hay', 'đẹp', 'thích', 'ok', 'ổn', 'cảm ơn', 'thanks'];
        $negativeWords = ['tệ', 'kém', 'không tốt', 'chán', 'tệ quá', 'không hài lòng'];

        $positiveCount = 0;
        $negativeCount = 0;

        foreach ($positiveWords as $word) {
            if (mb_strpos($message, $word) !== false) {
                $positiveCount++;
            }
        }

        foreach ($negativeWords as $word) {
            if (mb_strpos($message, $word) !== false) {
                $negativeCount++;
            }
        }

        if ($negativeCount > $positiveCount) {
            return ['sentiment' => 'negative', 'should_escalate' => $negativeCount >= 2];
        } elseif ($positiveCount > $negativeCount) {
            return ['sentiment' => 'positive', 'should_escalate' => false];
        }

        return ['sentiment' => 'neutral', 'should_escalate' => false];
    }
}
