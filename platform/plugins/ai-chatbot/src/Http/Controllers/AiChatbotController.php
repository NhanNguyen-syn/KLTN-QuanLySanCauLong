<?php

namespace Botble\AiChatbot\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Setting\Facades\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiChatbotController extends BaseController
{
    public function index()
    {
        $this->pageTitle('Trợ lý AI');

        $stats = [
            'total_conversations' => DB::table('ai_chat_conversations')->count(),
            'today_conversations' => DB::table('ai_chat_conversations')
                ->whereDate('created_at', today())
                ->count(),
            'knowledge_items' => DB::table('ai_knowledge_items')->count(),
        ];

        $provider = setting('ai_chatbot_llm_provider', 'gemini');
        $hasApiKey = \Botble\AiChatbot\Models\ApiKey::hasKey($provider);

        return view('plugins/ai-chatbot::index', compact('stats', 'hasApiKey'));
    }

    public function liveChat()
    {
        $this->pageTitle('Live Chat - Hỗ trợ trực tiếp');

        return view('plugins/ai-chatbot::live-chat');
    }

    public function knowledge()
    {
        $this->pageTitle('Knowledge Base');

        $items = DB::table('ai_knowledge_items')
            ->orderBy('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('plugins/ai-chatbot::knowledge', compact('items'));
    }

    public function storeKnowledge(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:court,pricing,promotion,faq,general',
        ]);

        DB::table('ai_knowledge_items')->insert([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('ai-chatbot.knowledge')
            ->with('success', 'Đã thêm knowledge item thành công!');
    }

    public function deleteKnowledge($id)
    {
        DB::table('ai_knowledge_items')->where('id', $id)->delete();

        return redirect()->route('ai-chatbot.knowledge')
            ->with('success', 'Đã xóa tri thức!');
    }

    public function updateKnowledge(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:court,pricing,promotion,faq,general',
        ]);

        DB::table('ai_knowledge_items')
            ->where('id', $id)
            ->update([
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'is_active' => $request->boolean('is_active', true),
                'updated_at' => now(),
            ]);

        return redirect()->route('ai-chatbot.knowledge')
            ->with('success', 'Đã cập nhật tri thức thành công!');
    }

    public function conversations()
    {
        $this->pageTitle('Conversations');

        $conversations = DB::table('ai_chat_conversations')
            ->leftJoin('members', 'ai_chat_conversations.member_id', '=', 'members.id')
            ->select('ai_chat_conversations.*', 'members.first_name', 'members.last_name')
            ->orderBy('ai_chat_conversations.updated_at', 'desc')
            ->paginate(20);

        return view('plugins/ai-chatbot::conversations', compact('conversations'));
    }

    public function settings()
    {
        $this->pageTitle('AI Chatbot Settings');

        $settings = [
            'llm_provider' => setting('ai_chatbot_llm_provider', 'gemini'),
            'welcome_message' => setting('ai_chatbot_welcome_message', 'Xin chào! Tôi có thể giúp gì cho bạn?'),
            'enabled' => setting('ai_chatbot_enabled', true),
        ];

        // Get API key info for each provider
        $apiKeys = [
            'gemini' => [
                'masked' => \Botble\AiChatbot\Models\ApiKey::getMaskedKeyForProvider('gemini'),
                'has_key' => \Botble\AiChatbot\Models\ApiKey::hasKey('gemini'),
                'model' => \Botble\AiChatbot\Models\ApiKey::getModelForProvider('gemini'),
                'models' => \Botble\AiChatbot\Models\ApiKey::GEMINI_MODELS,
            ],
            'openai' => [
                'masked' => \Botble\AiChatbot\Models\ApiKey::getMaskedKeyForProvider('openai'),
                'has_key' => \Botble\AiChatbot\Models\ApiKey::hasKey('openai'),
                'model' => \Botble\AiChatbot\Models\ApiKey::getModelForProvider('openai'),
                'models' => \Botble\AiChatbot\Models\ApiKey::OPENAI_MODELS,
            ],
        ];

        return view('plugins/ai-chatbot::settings', compact('settings', 'apiKeys'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'llm_provider' => 'required|in:openai,gemini',
            'gemini_api_key' => 'nullable|string',
            'openai_api_key' => 'nullable|string',
            'gemini_model' => 'nullable|string',
            'openai_model' => 'nullable|string',
            'welcome_message' => 'required|string|max:500',
        ]);

        // Save general settings to 'settings' table
        Setting::set([
            'ai_chatbot_llm_provider' => $request->llm_provider,
            'ai_chatbot_welcome_message' => $request->welcome_message,
            'ai_chatbot_enabled' => $request->boolean('enabled'),
        ])->save();

        // Save API keys to 'ai_api_keys' table
        \Botble\AiChatbot\Models\ApiKey::saveKey(
            'gemini',
            $request->gemini_api_key,
            $request->gemini_model
        );

        \Botble\AiChatbot\Models\ApiKey::saveKey(
            'openai',
            $request->openai_api_key,
            $request->openai_model
        );

        return redirect()->route('ai-chatbot.settings')
            ->with('success', 'Đã lưu cài đặt thành công!');
    }

    /**
     * Fetch available models from provider API
     */
    public function fetchModels(Request $request)
    {
        $provider = $request->input('provider');
        $apiKey = $request->input('api_key');

        // If no API key provided, try to get saved key from database
        if (empty($apiKey)) {
            $apiKey = \Botble\AiChatbot\Models\ApiKey::getKeyForProvider($provider);
        }

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Chưa có API key được lưu. Vui lòng nhập API key.',
                'models' => [],
            ]);
        }

        try {
            if ($provider === 'gemini') {
                $models = $this->fetchGeminiModels($apiKey);
            } else {
                $models = $this->fetchOpenAIModels($apiKey);
            }

            return response()->json([
                'success' => true,
                'models' => $models,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể kết nối API: ' . $e->getMessage(),
                'models' => [],
            ]);
        }
    }

    protected function fetchGeminiModels(string $apiKey): array
    {
        $response = \Illuminate\Support\Facades\Http::get(
            "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}"
        );

        if (!$response->successful()) {
            throw new \Exception('Invalid API key or API error');
        }

        $data = $response->json();
        $models = [];

        foreach ($data['models'] ?? [] as $model) {
            $name = $model['name'] ?? '';
            // Only include generative models
            if (str_contains($name, 'gemini')) {
                $modelId = str_replace('models/', '', $name);
                $displayName = $model['displayName'] ?? $modelId;
                $models[$modelId] = $displayName;
            }
        }

        return $models;
    }

    protected function fetchOpenAIModels(string $apiKey): array
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
        ])->get('https://api.openai.com/v1/models');

        if (!$response->successful()) {
            throw new \Exception('Invalid API key or API error');
        }

        $data = $response->json();
        $models = [];

        // Filter and sort GPT models
        $allowedPrefixes = ['gpt-3.5', 'gpt-4'];
        
        foreach ($data['data'] ?? [] as $model) {
            $modelId = $model['id'] ?? '';
            foreach ($allowedPrefixes as $prefix) {
                if (str_starts_with($modelId, $prefix)) {
                    // Create display name
                    $displayName = strtoupper(str_replace('-', ' ', $modelId));
                    $models[$modelId] = $displayName;
                    break;
                }
            }
        }

        // Sort by name
        ksort($models);

        return $models;
    }

    public function syncKnowledge()
    {
        // Sync courts
        $courts = DB::table('cb_courts')
            ->where('status', 'published')
            ->get();

        foreach ($courts as $court) {
            $this->upsertKnowledge(
                "court_{$court->id}",
                "Sân: {$court->name}",
                "Sân cầu lông {$court->name}. " . ($court->description ?? 'Sân tiêu chuẩn, đầy đủ tiện nghi.'),
                'court'
            );
        }

        // Sync time slots
        $slots = DB::table('cb_time_slots')
            ->where('status', 'published')
            ->get();

        foreach ($slots as $slot) {
            $price = $slot->price ? number_format($slot->price) . 'đ' : 'Liên hệ';
            $this->upsertKnowledge(
                "timeslot_{$slot->id}",
                "Khung giờ: {$slot->name}",
                "Khung giờ {$slot->name}: {$slot->start_time} - {$slot->end_time}. Giá: {$price}/giờ.",
                'pricing'
            );
        }

        $count = $courts->count() + $slots->count();

        return redirect()->route('ai-chatbot.knowledge')
            ->with('success', "Đã đồng bộ {$count} items từ database!");
    }

    protected function upsertKnowledge(string $refId, string $title, string $content, string $category): void
    {
        $existing = DB::table('ai_knowledge_items')
            ->where('title', $title)
            ->first();

        if ($existing) {
            DB::table('ai_knowledge_items')
                ->where('id', $existing->id)
                ->update([
                    'content' => $content,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('ai_knowledge_items')->insert([
                'title' => $title,
                'content' => $content,
                'category' => $category,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
