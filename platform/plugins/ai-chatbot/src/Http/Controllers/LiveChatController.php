<?php

namespace Botble\AiChatbot\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LiveChatController extends Controller
{
    /**
     * Get active chat sessions for receptionist
     */
    public function getActiveSessions(): JsonResponse
    {
        $sessions = DB::table('ai_chat_conversations')
            ->leftJoin('members', 'ai_chat_conversations.member_id', '=', 'members.id')
            ->select(
                'ai_chat_conversations.id',
                'ai_chat_conversations.session_id',
                'ai_chat_conversations.messages',
                'ai_chat_conversations.updated_at',
                'ai_chat_conversations.is_live',
                'members.first_name',
                'members.last_name',
                'members.email'
            )
            ->where('ai_chat_conversations.updated_at', '>=', now()->subHours(24))
            ->orderBy('ai_chat_conversations.updated_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($session) {
                $messages = json_decode($session->messages ?? '[]', true) ?: [];
                $lastMsg = end($messages);
                return [
                    'id' => $session->id,
                    'session_id' => $session->session_id,
                    'customer_name' => $session->first_name
                        ? $session->first_name . ' ' . $session->last_name
                        : 'Khách',
                    'email' => $session->email,
                    'message_count' => count($messages),
                    'last_message' => $lastMsg ? ($lastMsg['content'] ?? '') : '',
                    'last_role' => $lastMsg ? ($lastMsg['role'] ?? '') : '',
                    'updated_at' => $session->updated_at,
                    'is_live' => (bool) $session->is_live,
                ];
            });

        return response()->json([
            'success' => true,
            'sessions' => $sessions,
        ]);
    }

    /**
     * Get messages for a specific session
     */
    public function getSessionMessages(string $sessionId): JsonResponse
    {
        $conversation = DB::table('ai_chat_conversations')
            ->where('session_id', $sessionId)
            ->first();

        if (!$conversation) {
            return response()->json(['success' => false, 'error' => 'Session not found'], 404);
        }

        $messages = json_decode($conversation->messages ?? '[]', true) ?: [];

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'is_live' => (bool) $conversation->is_live,
        ]);
    }

    /**
     * Send message from receptionist (takeover)
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        $sessionId = $request->input('session_id');
        $message = $request->input('message');
        $staffName = auth()->user()?->name ?? 'Nhân viên';

        $conversation = DB::table('ai_chat_conversations')
            ->where('session_id', $sessionId)
            ->first();

        if (!$conversation) {
            return response()->json(['success' => false, 'error' => 'Session not found'], 404);
        }

        $messages = json_decode($conversation->messages ?? '[]', true) ?: [];
        $messages[] = [
            'role' => 'staff',
            'content' => $message,
            'staff_name' => $staffName,
            'time' => now()->toISOString(),
        ];

        DB::table('ai_chat_conversations')
            ->where('id', $conversation->id)
            ->update([
                'messages' => json_encode($messages),
                'is_live' => true,
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi tin nhắn!',
        ]);
    }

    /**
     * Toggle live mode (takeover/release)
     */
    public function toggleLive(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'is_live' => 'required|boolean',
        ]);

        DB::table('ai_chat_conversations')
            ->where('session_id', $request->input('session_id'))
            ->update([
                'is_live' => $request->input('is_live'),
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => $request->input('is_live') ? 'Đã tiếp quản chat!' : 'Đã trả lại cho AI!',
        ]);
    }
}
