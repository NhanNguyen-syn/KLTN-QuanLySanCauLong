<?php

namespace Botble\AiChatbot\Http\Controllers;

use Botble\AiChatbot\Services\AiChatService;
use Botble\AiChatbot\Services\IntentDetectionService;
use Botble\AiChatbot\Services\ContextManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChatApiController extends Controller
{
    protected AiChatService $chatService;
    protected IntentDetectionService $intentDetector;
    protected ContextManagerService $contextManager;

    public function __construct(
        AiChatService $chatService,
        IntentDetectionService $intentDetector,
        ContextManagerService $contextManager
    ) {
        $this->chatService = $chatService;
        $this->intentDetector = $intentDetector;
        $this->contextManager = $contextManager;
    }

    /**
     * Handle chat message
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string|max:100',
            'history' => 'array',
        ]);

        $message = $request->input('message');
        $sessionId = $request->input('session_id');
        $history = $request->input('history', []);

        // Detect intent and extract entities
        $intent = $this->intentDetector->detectIntent($message, $sessionId);

        // Save message to context
        $this->contextManager->addMessage($sessionId, 'user', $message);

        // Get contextual prompt
        $contextualMessage = $this->contextManager->getContextualPrompt($sessionId, $message);

        // Check if this session is in live mode (staff takeover)
        $conversation = DB::table('ai_chat_conversations')
            ->where('session_id', $sessionId)
            ->first();

        $isLive = $conversation && $conversation->is_live;

        if ($isLive) {
            // In live mode, just save user message, don't auto-respond
            $this->saveUserMessageOnly($sessionId, $message);

            return response()->json([
                'success' => true,
                'response' => null, // No auto response, staff will reply
                'is_live' => true,
                'message' => 'Nhân viên sẽ phản hồi bạn ngay!',
            ]);
        }

        // Normal AI response
        $result = $this->chatService->chat($message, $history);
        $this->saveConversation($sessionId, $message, $result['response'], $result['actions'] ?? []);

        $jsonResponse = [
            'success' => true,
            'response' => $result['response'],
            'sources' => $result['sources'],
            'actions' => $result['actions'] ?? [],
            'is_live' => false,
        ];

        // Pass booking_data if AI provided it (for localStorage on frontend)
        if (!empty($result['booking_data'])) {
            $jsonResponse['booking_data'] = $result['booking_data'];
        }

        return response()->json($jsonResponse);
    }

    /**
     * Poll for new messages (for customer widget when in live mode)
     */
    public function poll(string $sessionId): JsonResponse
    {
        $conversation = DB::table('ai_chat_conversations')
            ->where('session_id', $sessionId)
            ->first();

        if (!$conversation) {
            return response()->json(['success' => false, 'messages' => []]);
        }

        $messages = json_decode($conversation->messages ?? '[]', true) ?: [];

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'is_live' => (bool) $conversation->is_live,
        ]);
    }

    /**
     * Get chatbot status
     */
    public function status(): JsonResponse
    {
        $enabled = setting('ai_chatbot_enabled', true);
        $provider = setting('ai_chatbot_llm_provider', 'gemini');
        $hasApiKey = \Botble\AiChatbot\Models\ApiKey::hasKey($provider);

        return response()->json([
            'enabled' => $enabled,
            'configured' => $hasApiKey,
            'welcome_message' => setting('ai_chatbot_welcome_message', 'Xin chào! Tôi có thể giúp gì cho bạn?'),
        ]);
    }

    /**
     * Save only user message (when in live mode)
     */
    protected function saveUserMessageOnly(string $sessionId, string $userMessage): void
    {
        $conversation = DB::table('ai_chat_conversations')
            ->where('session_id', $sessionId)
            ->first();

        $newMessage = ['role' => 'user', 'content' => $userMessage, 'time' => now()->toISOString()];

        if ($conversation) {
            $messages = json_decode($conversation->messages, true) ?? [];
            $messages[] = $newMessage;

            DB::table('ai_chat_conversations')
                ->where('id', $conversation->id)
                ->update([
                    'messages' => json_encode($messages),
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Save conversation to database
     */
    protected function saveConversation(string $sessionId, string $userMessage, string $botResponse, array $actions = []): void
    {
        $conversation = DB::table('ai_chat_conversations')
            ->where('session_id', $sessionId)
            ->first();

        $botMessageData = [
            'role' => 'assistant',
            'content' => $botResponse,
            'time' => now()->toISOString(),
        ];
        
        // Add actions to message if present
        if (!empty($actions)) {
            $botMessageData['actions'] = $actions;
        }

        $newMessages = [
            ['role' => 'user', 'content' => $userMessage, 'time' => now()->toISOString()],
            $botMessageData,
        ];

        if ($conversation) {
            $messages = json_decode($conversation->messages, true) ?? [];
            $messages = array_merge($messages, $newMessages);

            DB::table('ai_chat_conversations')
                ->where('id', $conversation->id)
                ->update([
                    'messages' => json_encode($messages),
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('ai_chat_conversations')->insert([
                'session_id' => $sessionId,
                'member_id' => auth('member')->id(),
                'messages' => json_encode($newMessages),
                'is_live' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Track action button click for learning
     */
    public function trackAction(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string|max:100',
            'query' => 'required|string|max:500',
            'action_url' => 'required|string|max:100',
            'action_label' => 'required|string|max:200',
        ]);

        $sessionId = $request->input('session_id');
        $query = $request->input('query');
        $actionUrl = $request->input('action_url');
        $actionLabel = $request->input('action_label');
        $wasHelpful = $request->input('was_helpful'); // Optional

        // Check if table exists before inserting
        if (!Schema::hasTable('ai_interaction_logs')) {
            return response()->json(['success' => true, 'message' => 'Learning tables not yet created']);
        }

        try {
            // Log the interaction
            DB::table('ai_interaction_logs')->insert([
                'session_id' => $sessionId,
                'member_id' => auth('member')->id(),
                'query' => mb_substr($query, 0, 500),
                'action_clicked' => $actionUrl,
                'action_label' => $actionLabel,
                'was_helpful' => $wasHelpful,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update or create query pattern
            $this->updateQueryPattern($query, $actionUrl, $actionLabel, $wasHelpful);

            return response()->json([
                'success' => true,
                'message' => 'Interaction logged for learning',
            ]);
        } catch (\Exception $e) {
            // Silently fail - don't break user experience
            return response()->json(['success' => true]);
        }
    }

    /**
     * Update query pattern for learning
     */
    protected function updateQueryPattern(string $query, string $actionUrl, string $actionLabel, ?bool $wasHelpful): void
    {
        if (!Schema::hasTable('ai_query_patterns')) {
            return;
        }

        // Normalize query to pattern (lowercase, remove extra spaces)
        $pattern = mb_strtolower(preg_replace('/\s+/', ' ', trim($query)));
        $pattern = mb_substr($pattern, 0, 200);

        $existing = DB::table('ai_query_patterns')
            ->where('pattern', $pattern)
            ->first();

        if ($existing) {
            // Update existing pattern
            $clickCount = $existing->click_count + 1;
            $successRate = $existing->success_rate;
            
            if ($wasHelpful !== null) {
                // Recalculate success rate
                $totalHelpful = ($existing->success_rate / 100) * $existing->click_count;
                if ($wasHelpful) {
                    $totalHelpful++;
                }
                $successRate = ($totalHelpful / $clickCount) * 100;
            }

            // Update best action if this one is clicked more
            $updates = [
                'click_count' => $clickCount,
                'success_rate' => $successRate,
                'updated_at' => now(),
            ];

            // Simple heuristic: if same action, update it
            if ($existing->best_action_url === $actionUrl) {
                $updates['best_action_label'] = $actionLabel;
            }

            DB::table('ai_query_patterns')
                ->where('id', $existing->id)
                ->update($updates);
        } else {
            // Create new pattern
            DB::table('ai_query_patterns')->insert([
                'pattern' => $pattern,
                'best_action_url' => $actionUrl,
                'best_action_label' => $actionLabel,
                'click_count' => 1,
                'success_rate' => $wasHelpful ? 100 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Get list of available courts for chatbot booking
     */
    public function getCourts(): JsonResponse
    {
        try {
            $courts = DB::table('courts')
                ->where('status', 'published')
                ->orderBy('name')
                ->get(['id', 'name', 'default_price', 'member_price']);

            return response()->json([
                'success' => true,
                'courts' => $courts->map(fn($c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'price' => number_format($c->default_price ?? 0, 0, ',', '.') . 'đ',
                    'price_raw' => $c->default_price ?? 0,
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi tải danh sách sân'], 500);
        }
    }

    /**
     * Get available time slots for a court on a specific date
     */
    public function getAvailableSlots(Request $request): JsonResponse
    {
        try {
            $courtId = (int) $request->query('court_id');
            $date = $request->query('date', date('Y-m-d'));

            if (!$courtId) {
                return response()->json(['success' => false, 'message' => 'Thiếu court_id'], 422);
            }

            $court = DB::table('courts')->find($courtId);
            if (!$court || $court->status !== 'published') {
                return response()->json(['success' => false, 'message' => 'Sân không tồn tại'], 404);
            }

            // Get booked slots for this court on this date
            $bookedSlots = DB::table('court_bookings_list')
                ->where('court_id', $courtId)
                ->where('date', $date)
                ->whereIn('status', ['confirmed', 'completed', 'paid', 'processing', 'pending'])
                ->orderBy('start_time')
                ->get(['start_time', 'end_time', 'status']);

            // Generate all 30-min slots from 05:00 to 23:00
            $allSlots = [];
            $current = strtotime($date . ' 05:00');
            $end = strtotime($date . ' 23:00');
            $now = time();

            while ($current < $end) {
                $slotStart = date('H:i', $current);
                $slotEnd = date('H:i', $current + 1800);

                $isBooked = false;
                foreach ($bookedSlots as $booked) {
                    if ($slotStart < $booked->end_time && $slotEnd > $booked->start_time) {
                        $isBooked = true;
                        break;
                    }
                }

                // For today, mark past slots
                $isPast = ($date === date('Y-m-d') && $current < $now);

                $allSlots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                    'available' => !$isBooked && !$isPast,
                    'booked' => $isBooked,
                    'past' => $isPast,
                ];

                $current += 1800;
            }

            return response()->json([
                'success' => true,
                'court_name' => $court->name,
                'date' => $date,
                'price_per_slot' => $court->default_price ?? 0,
                'slots' => $allSlots,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi tải giờ trống'], 500);
        }
    }

    /**
     * Create booking from chatbot
     */
    public function createBooking(Request $request): JsonResponse
    {
        try {
            $courtId = (int) $request->input('court_id');
            $courtName = $request->input('court_name', '');
            $date = $request->input('date');
            $slots = $request->input('slots', []);
            $customerName = $request->input('customer_name', '');
            $contact = $request->input('contact', '');
            $email = $request->input('email', '');

            // Validate
            if (!$courtId || !$date || empty($slots)) {
                return response()->json(['success' => false, 'message' => 'Thiếu thông tin đặt sân'], 422);
            }
            if (!$customerName || !$contact) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập họ tên và số điện thoại'], 422);
            }

            $court = DB::table('courts')->find($courtId);
            if (!$court) {
                return response()->json(['success' => false, 'message' => 'Sân không tồn tại'], 404);
            }

            // Check for conflicts - verify slots are still available
            $bookedSlots = DB::table('court_bookings_list')
                ->where('court_id', $courtId)
                ->where('date', $date)
                ->whereIn('status', ['confirmed', 'completed', 'paid', 'processing', 'pending'])
                ->get(['start_time', 'end_time']);

            $conflicting = [];
            foreach ($slots as $slot) {
                foreach ($bookedSlots as $booked) {
                    if ($slot['start'] < $booked->end_time && $slot['end'] > $booked->start_time) {
                        $conflicting[] = $slot['start'] . '-' . $slot['end'];
                        break;
                    }
                }
            }

            if (!empty($conflicting)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Các khung giờ sau đã bị đặt: ' . implode(', ', $conflicting) . '. Vui lòng chọn giờ khác.',
                    'conflicts' => $conflicting,
                ], 409);
            }

            // Create booking via internal logic (same as BookingListController)
            DB::beginTransaction();

            $pricePerSlot = $court->default_price ?? 0;
            $dateForCode = \Carbon\Carbon::parse($date);
            $prefix = 'BD-' . $dateForCode->format('Ymd') . '-';
            
            $latest = DB::table('court_bookings_list')
                ->where('order_code', 'like', $prefix . '%')
                ->lockForUpdate()
                ->orderBy('order_code', 'desc')
                ->value('order_code');

            $nextSeq = 1;
            if ($latest) {
                $lastSeqStr = substr($latest, strrpos($latest, '-') + 1);
                $nextSeq = ((int) $lastSeqStr) + 1;
            }
            $orderCode = $prefix . str_pad((string) $nextSeq, 3, '0', STR_PAD_LEFT);

            // Set expiry: 15 minutes from now
            $expiresAt = now()->addMinutes(15)->format('Y-m-d H:i:s');

            foreach ($slots as $slot) {
                DB::table('court_bookings_list')->insert([
                    'order_code' => $orderCode,
                    'court_id' => $courtId,
                    'court_name' => $court->name,
                    'date' => $date,
                    'start_time' => $slot['start'],
                    'end_time' => $slot['end'],
                    'status' => 'processing',
                    'customer_name' => $customerName,
                    'contact' => $contact,
                    'email' => $email,
                    'price' => $pricePerSlot,
                    'paid_amount' => 0,
                    'notes' => 'chatbot_booking|expires_at:' . $expiresAt,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            $totalAmount = $pricePerSlot * count($slots);

            return response()->json([
                'success' => true,
                'order_code' => $orderCode,
                'total_amount' => number_format($totalAmount, 0, ',', '.') . 'đ',
                'total_raw' => $totalAmount,
                'slot_count' => count($slots),
                'expires_at' => $expiresAt,
                'message' => 'Đặt sân thành công! Vui lòng thanh toán trong 15 phút.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi tạo đơn: ' . $e->getMessage()], 500);
        }
    }
}
