<?php

namespace Botble\AiChatbot\Services;

use Botble\AiChatbot\Models\ApiKey;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AiChatService
{
    protected string $provider;
    protected ?string $apiKey;
    protected string $model;
    protected array $knowledgeBase = [];

    public function __construct()
    {
        $this->provider = setting('ai_chatbot_llm_provider', 'gemini');
        $this->apiKey = ApiKey::getKeyForProvider($this->provider);
        $this->model = ApiKey::getModelForProvider($this->provider);
    }

    /**
     * Action buttons mapping based on keywords
     * These are suggested actions based on user query keywords
     */
    protected array $actionMappings = [
        'giá sân' => [
            'label' => 'Xem sân & giá',
            'url' => '/san-gia',
            'icon' => 'money',
            'type' => 'secondary'
        ],
        'giá thuê' => [
            'label' => 'Xem sân & giá',
            'url' => '/san-gia',
            'icon' => 'money',
            'type' => 'secondary'
        ],
        'bao nhiêu' => [
            'label' => 'Xem sân & giá',
            'url' => '/san-gia',
            'icon' => 'money',
            'type' => 'secondary'
        ],
        'danh sách sân' => [
            'label' => 'Xem danh sách sân & giá',
            'url' => '/san-gia',
            'icon' => 'list',
            'type' => 'secondary'
        ],
        'xem sân' => [
            'label' => 'Xem danh sách sân & giá',
            'url' => '/san-gia',
            'icon' => 'list',
            'type' => 'secondary'
        ],
        'chính sách' => [
            'label' => 'Xem chính sách',
            'url' => '/chinh-sach-huy-doi-hoan',
            'icon' => 'file-text',
            'type' => 'secondary'
        ],
        'hủy' => [
            'label' => 'Chính sách hủy/đổi/hoàn',
            'url' => '/chinh-sach-huy-doi-hoan',
            'icon' => 'file-text',
            'type' => 'secondary'
        ],
        'hoàn tiền' => [
            'label' => 'Chính sách hoàn tiền',
            'url' => '/chinh-sach-huy-doi-hoan',
            'icon' => 'file-text',
            'type' => 'secondary'
        ],
        'đổi lịch' => [
            'label' => 'Chính sách đổi lịch',
            'url' => '/chinh-sach-huy-doi-hoan',
            'icon' => 'refresh',
            'type' => 'secondary'
        ],
        'đánh giá' => [
            'label' => 'Xem đánh giá',
            'url' => '/danh-gia',
            'icon' => 'star',
            'type' => 'secondary'
        ],
        'review' => [
            'label' => 'Xem đánh giá',
            'url' => '/danh-gia',
            'icon' => 'star',
            'type' => 'secondary'
        ],
        'tra cứu' => [
            'label' => 'Tra cứu đơn hàng',
            'url' => '/tra-cuu',
            'icon' => 'search',
            'type' => 'secondary'
        ],
        'đơn hàng' => [
            'label' => 'Tra cứu đơn hàng',
            'url' => '/tra-cuu',
            'icon' => 'search',
            'type' => 'secondary'
        ],
        'liên hệ' => [
            'label' => 'Về chúng tôi',
            'url' => '/ve-chung-toi',
            'icon' => 'info',
            'type' => 'secondary'
        ],
        'hotline' => [
            'label' => 'Về chúng tôi',
            'url' => '/ve-chung-toi',
            'icon' => 'phone',
            'type' => 'secondary'
        ],
        'tiêu chuẩn' => [
            'label' => 'Tiêu chuẩn dịch vụ',
            'url' => '/tieu-chuan-dich-vu',
            'icon' => 'check-circle',
            'type' => 'secondary'
        ],
    ];

    /**
     * Generate AI response for user message
     */
    public function chat(string $message, array $history = []): array
    {
        // Get relevant knowledge
        $context = $this->searchKnowledge($message);

        // ✅ Get real-time database context (courts count, booking lookup, booking conversation)
        $dbContext = $this->getDatabaseContext($message, $history);

        // Build prompt with step-by-step instruction format
        $prompt = $this->buildPrompt($message, $context, $history, $dbContext);

        // Call LLM
        $rawResponse = $this->callLLM($prompt);

        // Parse AI response - extract text, actions, and booking_data from JSON
        $parsed = $this->parseAIResponse($rawResponse);
        
        // If AI didn't provide actions, fallback to keyword matching
        if (empty($parsed['actions'])) {
            $parsed['actions'] = $this->getActionsForQuery($message);
        }

        $result = [
            'response' => $parsed['response'],
            'sources' => array_column($context, 'title'),
            'actions' => $parsed['actions'],
        ];

        // Pass booking_data if AI provided it (for localStorage storage on frontend)
        if (!empty($parsed['booking_data'])) {
            $result['booking_data'] = $parsed['booking_data'];
        }

        return $result;
    }

    /**
     * Parse AI response - extract JSON or fallback to plain text
     */
    protected function parseAIResponse(string $rawResponse): array
    {
        // Try to extract JSON from response
        $response = trim($rawResponse);
        
        // Remove markdown code blocks if present (handle multiline)
        if (preg_match('/```(?:json)?\s*([\s\S]*?)```/s', $response, $matches)) {
            $response = trim($matches[1]);
        }
        
        // Try to find JSON start/end if mixed with text
        if (!str_starts_with($response, '{')) {
            if (preg_match('/\{[\s\S]*"response"[\s\S]*\}/s', $response, $matches)) {
                $response = $matches[0];
            }
        }
        
        // Try to parse as JSON
        $decoded = json_decode($response, true);
        
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['response'])) {
            // Valid JSON with response field
            $actions = [];
            if (isset($decoded['actions']) && is_array($decoded['actions'])) {
                foreach ($decoded['actions'] as $action) {
                    if (isset($action['label'], $action['url'])) {
                        $actions[] = [
                            'label' => $action['label'],
                            'url' => $action['url'],
                            'icon' => $action['icon'] ?? 'info',
                            'type' => $action['type'] ?? 'secondary',
                        ];
                    }
                }
            }
            
            $result = [
                'response' => $decoded['response'],
                'actions' => array_slice($actions, 0, 2), // Max 2 actions
            ];

            // Extract booking_data if AI provided it
            if (isset($decoded['booking_data']) && is_array($decoded['booking_data'])) {
                $result['booking_data'] = $decoded['booking_data'];
            }

            return $result;
        }

        // Fallback: Regex extract "response" if JSON is invalid (e.g. unescaped newlines)
        if (preg_match('/"response"\s*:\s*"((?:[^"\\\\]|\\\\.)*)"/s', $response, $matches)) {
            // Decode the string value to handle escapes
            $responseText = json_decode('"' . $matches[1] . '"');
            if ($responseText) {
                 return [
                    'response' => $responseText,
                    'actions' => [],
                 ];
            }
        }
        
        // Fallback: try to clean up raw response if it contains partial JSON
        $cleanResponse = $rawResponse;
        $cleanResponse = preg_replace('/```(?:json)?/s', '', $cleanResponse);
        $cleanResponse = preg_replace('/```/s', '', $cleanResponse);
        
        // If it still looks like a JSON object, try to extract just the response text
        if (str_contains($cleanResponse, '"response":')) {
             // Extract content between "response": " AND the next Quote-Comma-Keys or closing brace
             // This regex looks for: "response" : " (CONTENT) " , "next_key" OR " }
             if (preg_match('/"response"\s*:\s*"((?:[^"\\\\]|\\\\.)*)"\s*(?:,|})/s', $cleanResponse, $matches)) {
                 $cleanResponse = $matches[1];
                 // Manually handle common escapes if json_decode failed earlier
                 $cleanResponse = str_replace(['\\"', '\\\\', '\\n', '\\t'], ['"', '\\', "\n", "\t"], $cleanResponse);
             } else {
                 // Brute force cleanup if regex fails (rare)
                 $cleanResponse = preg_replace('/^\s*\{\s*"response"\s*:\s*"/s', '', $cleanResponse);
                 $cleanResponse = preg_replace('/"\s*(?:,\s*"actions".*)?\}\s*$/s', '', $cleanResponse);
             }
        }

        $cleanResponse = trim($cleanResponse);
        
        return [
            'response' => $cleanResponse,
            'actions' => [],
        ];
    }

    /**
     * Get action buttons based on query - uses learned patterns first, then fallback to keywords
     */
    protected function getActionsForQuery(string $query): array
    {
        // First, check if we have a learned pattern for this query
        $learnedActions = $this->getLearnedActions($query);
        if (!empty($learnedActions)) {
            return $learnedActions;
        }

        // Fallback to keyword-based matching
        $query = mb_strtolower($query);
        $actions = [];
        $addedUrls = []; // Avoid duplicate buttons

        foreach ($this->actionMappings as $keyword => $action) {
            if (str_contains($query, $keyword) && !in_array($action['url'], $addedUrls)) {
                $actions[] = $action;
                $addedUrls[] = $action['url'];
                
                // Limit to max 2 action buttons
                if (count($actions) >= 2) {
                    break;
                }
            }
        }

        return $actions;
    }

    /**
     * Get actions from learned patterns
     */
    protected function getLearnedActions(string $query): array
    {
        if (!Schema::hasTable('ai_query_patterns')) {
            return [];
        }

        // Normalize query
        $normalizedQuery = mb_strtolower(preg_replace('/\s+/', ' ', trim($query)));
        
        // Look for exact or similar patterns with good success rate
        $patterns = DB::table('ai_query_patterns')
            ->where('pattern', 'LIKE', '%' . $normalizedQuery . '%')
            ->orWhere('pattern', $normalizedQuery)
            ->where('click_count', '>=', 3) // Only use patterns with enough data
            ->where('success_rate', '>=', 50) // Only successful patterns
            ->orderByDesc('click_count')
            ->limit(2)
            ->get();

        if ($patterns->isEmpty()) {
            return [];
        }

        $actions = [];
        $addedUrls = [];

        foreach ($patterns as $pattern) {
            if (!in_array($pattern->best_action_url, $addedUrls)) {
                $actions[] = [
                    'label' => $pattern->best_action_label,
                    'url' => $pattern->best_action_url,
                    'icon' => $this->guessIconFromUrl($pattern->best_action_url),
                    'type' => count($actions) === 0 ? 'primary' : 'secondary',
                ];
                $addedUrls[] = $pattern->best_action_url;
            }
        }

        return array_slice($actions, 0, 2);
    }

    /**
     * Guess icon from URL
     */
    protected function guessIconFromUrl(string $url): string
    {
        $iconMap = [
            '/dat-san' => 'calendar',
            '/san-gia' => 'money',
            '/chinh-sach' => 'file-text',
            '/danh-gia' => 'star',
            '/tra-cuu' => 'search',
            '/ve-chung-toi' => 'info',
        ];

        foreach ($iconMap as $path => $icon) {
            if (str_contains($url, $path)) {
                return $icon;
            }
        }

        return 'info';
    }

    /**
     * Get real-time database context based on user query
     */
    protected function getDatabaseContext(string $query, array $history = []): array
    {
        $context = [];
        $queryLower = mb_strtolower($query);

        // ✅ Check if asking about courts count
        if (preg_match('/(bao nhiêu|có mấy|số lượng|danh sách).*(sân|court)/ui', $query) ||
            preg_match('/(sân|court).*(bao nhiêu|có mấy|số lượng)/ui', $query)) {
            $context['courts'] = $this->getCourtsInfo();
        }

        // ✅ Check for booking code patterns
        if (preg_match('/\b(BD[-_]?\d{6,}[-_]?\d*|BK[-_]?\d{4,}[-_]?\d*|[A-Z]{2}[-_]\d{6,}[-_]\d+|#\d{6,}|\d{8,})\b/i', $query, $matches)) {
            $bookingCode = $matches[1];
            $context['booking'] = $this->lookupBooking($bookingCode);
        }

        // ✅ Check if user mentions "mã đơn" or "tra cứu đơn"
        if (preg_match('/(mã đơn|mã booking|tra cứu|kiểm tra đơn|đơn hàng|đơn đặt)/ui', $query)) {
            if (preg_match('/\b([A-Z]{2}[-_]?\d+[-_]?\d*|\d{6,})\b/i', $query, $matches)) {
                if (!isset($context['booking'])) {
                    $context['booking'] = $this->lookupBooking($matches[1]);
                }
            }
        }

        // ✅ Check if asking about court availability
        if (preg_match('/(sân\s*(\d+)|court\s*(\d+)).*(trống|available|còn|rảnh|còn giờ|giờ nào)/ui', $query, $matches) ||
            preg_match('/(trống|available|còn|rảnh|còn giờ|giờ nào).*(sân\s*(\d+)|court\s*(\d+))/ui', $query, $matches)) {
            preg_match('/sân\s*(\d+)|court\s*(\d+)/ui', $query, $courtMatch);
            $courtNumber = $courtMatch[1] ?? $courtMatch[2] ?? null;
            if ($courtNumber) {
                $context['availability'] = $this->getCourtAvailability((int)$courtNumber);
            }
        }

        // ✅ Check if asking about all courts availability today
        if (preg_match('/(hôm nay|today).*(trống|available|còn|rảnh)/ui', $query) ||
            preg_match('/(trống|available|còn|rảnh).*(hôm nay|today)/ui', $query) ||
            preg_match('/sân nào.*(trống|còn|rảnh)/ui', $query)) {
            $context['all_availability'] = $this->getAllCourtsAvailability();
        }

        // ✅ Detect booking intent OR ongoing booking conversation
        $isBookingConversation = $this->isBookingConversation($query, $history);
        if ($isBookingConversation) {
            $context['booking_intent'] = true;
            // Always provide courts + availability info for booking conversations
            if (!isset($context['courts'])) {
                $context['courts'] = $this->getCourtsInfo();
            }
            // Parse date from user message (ngày mai, DD/MM, YYYY-MM-DD, etc.)
            $bookingDate = $this->parseDateFromMessage($query, $history);
            $context['all_availability'] = $this->getAllCourtsAvailability($bookingDate);
            if ($bookingDate && $bookingDate !== date('Y-m-d')) {
                $context['requested_date'] = $bookingDate;
            }
        }

        return $context;
    }

    /**
     * Check if user is in a booking conversation based on query + history
     */
    protected function isBookingConversation(string $query, array $history = []): bool
    {
        // Direct booking intent
        if (preg_match('/(đặt\s*sân|muốn\s*đặt|thuê\s*sân|book\s*court|đặt.*ngay|đặt.*giờ|muốn.*thuê)/ui', $query)) {
            return true;
        }

        // Check if recent history contains booking conversation
        $recentHistory = array_slice($history, -6);
        foreach ($recentHistory as $msg) {
            if (isset($msg['role']) && $msg['role'] === 'assistant') {
                $content = $msg['content'] ?? '';
                if (preg_match('/(chọn sân|chọn giờ|thông tin cá nhân|họ tên|số điện thoại|xác nhận đặt|đặt sân)/ui', $content)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Parse date from user message for booking (supports Vietnamese date formats)
     */
    protected function parseDateFromMessage(string $query, array $history = []): ?string
    {
        $allText = $query;
        // Also check recent history for date mentions
        foreach (array_slice($history, -4) as $msg) {
            if (isset($msg['content'])) {
                $allText .= ' ' . $msg['content'];
            }
        }

        // "ngày mai" / "mai"
        if (preg_match('/(ngày\s*mai|\bmai\b)/ui', $allText)) {
            return date('Y-m-d', strtotime('+1 day'));
        }

        // "ngày kia" / "ngày mốt"
        if (preg_match('/(ngày\s*kia|ngày\s*mốt)/ui', $allText)) {
            return date('Y-m-d', strtotime('+2 days'));
        }

        // "hôm nay"
        if (preg_match('/(hôm\s*nay|today)/ui', $allText)) {
            return date('Y-m-d');
        }

        // "ngày DD" (e.g. ngày 15) -> assume current month/year, or next month if passed
        if (preg_match('/ngày\s*(\d{1,2})\b/ui', $allText, $m)) {
            $day = (int)$m[1];
            if ($day >= 1 && $day <= 31) {
                $currentDay = (int)date('d');
                $month = (int)date('m');
                $year = (int)date('Y');
                
                // If day is past, assume next month
                if ($day < $currentDay) {
                    $month++;
                    if ($month > 12) {
                        $month = 1;
                        $year++;
                    }
                }
                
                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                if (strtotime($date) !== false) return $date;
            }
        }

        // DD/MM/YYYY or DD-MM-YYYY
        if (preg_match('/(\d{1,2})[\/-](\d{1,2})[\/-](\d{4})/', $allText, $m)) {
            $date = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
            if (strtotime($date) !== false) return $date;
        }

        // DD/MM (assume current year)
        if (preg_match('/(\d{1,2})[\/-](\d{1,2})(?!\d)/', $allText, $m)) {
            $date = date('Y') . sprintf('-%02d-%02d', $m[2], $m[1]);
            if (strtotime($date) !== false && strtotime($date) >= strtotime(date('Y-m-d'))) return $date;
        }

        // YYYY-MM-DD (ISO format)
        if (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $allText, $m)) {
            return $m[0];
        }

        // Thứ + (hai|ba|tư|năm|sáu|bảy|CN)
        $dayMap = ['hai' => 1, 'ba' => 2, 'tư' => 3, 'năm' => 4, 'sáu' => 5, 'bảy' => 6, 'chủ nhật' => 0, 'cn' => 0];
        foreach ($dayMap as $dayName => $dayNum) {
            if (preg_match('/thứ\s*' . preg_quote($dayName, '/') . '/ui', $allText)) {
                $today = date('w'); // 0=Sun, 1=Mon
                $diff = $dayNum - $today;
                if ($diff <= 0) $diff += 7; // Next occurrence
                return date('Y-m-d', strtotime("+{$diff} days"));
            }
        }

        // Default to today if no date found
        return null;
    }

    /**
     * Get courts information from database
     */
    protected function getCourtsInfo(): array
    {
        try {
            $courts = DB::table('courts')
                ->where('status', 'published')
                ->get(['id', 'name', 'default_price', 'member_price', 'location']);

            $courtList = [];
            foreach ($courts as $court) {
                // default_price is per HOUR, each slot is 30 min = half price
                $pricePerSlot = ($court->default_price ?? 0) / 2;
                $memberPricePerSlot = ($court->member_price ?? 0) / 2;
                $courtList[] = [
                    'id' => $court->id,
                    'name' => $court->name,
                    'price' => number_format($pricePerSlot, 0, ',', '.') . 'đ',
                    'price_raw' => $pricePerSlot,
                    'member_price' => number_format($memberPricePerSlot, 0, ',', '.') . 'đ',
                    'location' => $court->location ?? '',
                ];
            }

            return [
                'total' => count($courtList),
                'courts' => $courtList,
            ];
        } catch (\Exception $e) {
            return ['total' => 0, 'courts' => [], 'error' => 'Không thể truy vấn dữ liệu sân'];
        }
    }

    /**
     * Lookup booking by code from court_bookings_list table
     */
    protected function lookupBooking(string $code): array
    {
        try {
            // Clean up code (remove # prefix if present)
            $code = preg_replace('/^#/', '', trim($code));

            // Query court_bookings_list table - this is the actual booking table
            // Column is 'order_code' not 'code'
            $bookings = DB::table('court_bookings_list')
                ->where('order_code', $code)
                ->orWhere('order_code', 'LIKE', '%' . $code . '%')
                ->orderBy('date')
                ->orderBy('start_time')
                ->get();

            if ($bookings->isEmpty()) {
                return ['found' => false, 'message' => 'Không tìm thấy đơn với mã: ' . $code];
            }

            // Get first booking for general info
            $firstBooking = $bookings->first();
            
            // Calculate total amount
            $totalAmount = $bookings->sum('price');
            
            // Build items list
            $itemDetails = [];
            foreach ($bookings as $item) {
                // Get court name
                $court = DB::table('courts')->find($item->court_id);
                $itemDetails[] = [
                    'court' => $court ? $court->name : 'Sân #' . $item->court_id,
                    'date' => $item->date ?? '',
                    'time' => ($item->start_time ?? '') . ' - ' . ($item->end_time ?? ''),
                    'price' => number_format($item->price ?? 0, 0, ',', '.') . 'đ',
                ];
            }

            // Map status to Vietnamese
            $statusMap = [
                'pending' => 'Chờ xác nhận',
                'confirmed' => 'Đã xác nhận', 
                'completed' => 'Hoàn thành',
                'cancelled' => 'Đã hủy',
                'paid' => 'Đã thanh toán',
                'processing' => 'Đang xử lý',
            ];

            return [
                'found' => true,
                'code' => $firstBooking->order_code,
                'status' => $statusMap[$firstBooking->status] ?? $firstBooking->status,
                'customer_name' => $firstBooking->customer_name ?? '',
                'phone' => $firstBooking->phone ?? '',
                'total' => number_format($totalAmount, 0, ',', '.') . 'đ',
                'items' => $itemDetails,
                'item_count' => count($itemDetails),
            ];
        } catch (\Exception $e) {
            return ['found' => false, 'message' => 'Lỗi tra cứu: ' . $e->getMessage()];
        }
    }

    /**
     * Get available time slots for a specific court today
     */
    protected function getCourtAvailability(int $courtNumber, ?string $date = null): array
    {
        try {
            $date = $date ?? date('Y-m-d');
            
            // Find court by number (name like "Sân 1", "Sân 2", etc)
            $court = DB::table('courts')
                ->where('status', 'published')
                ->where(function($q) use ($courtNumber) {
                    $q->where('name', 'LIKE', '%' . $courtNumber)
                      ->orWhere('name', 'LIKE', 'Sân ' . $courtNumber . '%')
                      ->orWhere('name', 'LIKE', 'Sân' . $courtNumber . '%')
                      ->orWhere('id', $courtNumber);
                })
                ->first();

            if (!$court) {
                return ['found' => false, 'message' => "Không tìm thấy Sân {$courtNumber}"];
            }

            // Get booked slots for this court today
            $bookedSlots = DB::table('court_bookings_list')
                ->where('court_id', $court->id)
                ->where('date', $date)
                ->whereIn('status', ['confirmed', 'completed', 'paid', 'processing', 'pending'])
                ->orderBy('start_time')
                ->get(['start_time', 'end_time']);

            // Define operating hours (5:00 - 23:00, 30-minute slots)
            // Last slot: 22:30-23:00
            $operatingStart = '05:00';
            $operatingEnd = '23:00';
            $slotMinutes = 30;

            // Generate all possible slots
            $allSlots = [];
            $current = strtotime($date . ' ' . $operatingStart);
            $end = strtotime($date . ' ' . $operatingEnd);
            
            while ($current < $end) {
                $slotStart = date('H:i', $current);
                $slotEnd = date('H:i', $current + ($slotMinutes * 60));
                $allSlots[] = ['start' => $slotStart, 'end' => $slotEnd];
                $current += ($slotMinutes * 60);
            }

            // Find available slots (not booked)
            $availableSlots = [];
            foreach ($allSlots as $slot) {
                $isBooked = false;
                foreach ($bookedSlots as $booked) {
                    // Check if slot overlaps with booked time
                    if ($slot['start'] < $booked->end_time && $slot['end'] > $booked->start_time) {
                        $isBooked = true;
                        break;
                    }
                }
                if (!$isBooked) {
                    // Only show future slots for today
                    if ($date === date('Y-m-d')) {
                        $now = date('H:i');
                        if ($slot['start'] > $now) {
                            $availableSlots[] = $slot['start'] . ' - ' . $slot['end'];
                        }
                    } else {
                        $availableSlots[] = $slot['start'] . ' - ' . $slot['end'];
                    }
                }
            }

            // Group consecutive slots
            $groupedSlots = $this->groupConsecutiveSlots($availableSlots);

            // Format booked slots for AI context
            $bookedDetails = $bookedSlots->map(function($slot) {
                return substr($slot->start_time, 0, 5) . '-' . substr($slot->end_time, 0, 5);
            })->toArray();

            return [
                'found' => true,
                'court_name' => $court->name,
                'date' => $date,
                'available_count' => count($availableSlots),
                'available_slots' => $groupedSlots,
                'booked_count' => $bookedSlots->count(),
                'booked_details' => $bookedDetails,
            ];
        } catch (\Exception $e) {
            return ['found' => false, 'message' => 'Lỗi kiểm tra: ' . $e->getMessage()];
        }
    }

    /**
     * Get availability for all courts today
     */
    protected function getAllCourtsAvailability(?string $date = null): array
    {
        $date = $date ?? date('Y-m-d');
        $courts = DB::table('courts')->where('status', 'published')->get(['id', 'name']);
        
        $results = [];
        foreach ($courts as $court) {
            $availability = $this->getCourtAvailability($court->id, $date);
            if ($availability['found']) {
                $results[] = [
                    'name' => $availability['court_name'],
                    'available_count' => $availability['available_count'],
                    'sample_slots' => array_slice($availability['available_slots'], 0, 5),
                    'booked_details' => $availability['booked_details'] ?? [],
                ];
            }
        }

        return [
            'date' => $date,
            'courts' => $results,
        ];
    }

    /**
     * Group consecutive time slots for cleaner display
     */
    protected function groupConsecutiveSlots(array $slots): array
    {
        if (empty($slots)) {
            return [];
        }

        // Instead of grouping, format as individual slot start times for clarity
        // E.g., ["15:00", "15:30", "16:00", ...] instead of "15:00-17:00"
        $startTimes = [];
        foreach ($slots as $slot) {
            preg_match('/(\d{2}:\d{2}) - (\d{2}:\d{2})/', $slot, $matches);
            $start = $matches[1] ?? null;
            if ($start) {
                $startTimes[] = $start;
            }
        }

        // Group consecutive start times into ranges for display
        // But show as "15:00, 15:30, 16:00, ..." for the first few, then summarize
        if (count($startTimes) <= 6) {
            return $startTimes; // Show all if 6 or fewer
        }

        // For many slots, group into ranges but show START times only
        $ranges = [];
        $rangeStart = null;
        $prevTime = null;
        
        foreach ($startTimes as $time) {
            if ($prevTime === null) {
                $rangeStart = $time;
            } else {
                // Check if consecutive (30 min apart)
                $prevMinutes = (int)substr($prevTime, 0, 2) * 60 + (int)substr($prevTime, 3, 2);
                $currMinutes = (int)substr($time, 0, 2) * 60 + (int)substr($time, 3, 2);
                
                if ($currMinutes - $prevMinutes > 30) {
                    // Gap found, close previous range
                    if ($rangeStart === $prevTime) {
                        $ranges[] = $rangeStart;
                    } else {
                        $ranges[] = $rangeStart . ' đến ' . $prevTime;
                    }
                    $rangeStart = $time;
                }
            }
            $prevTime = $time;
        }
        
        // Add last range
        if ($rangeStart !== null) {
            if ($rangeStart === $prevTime) {
                $ranges[] = $rangeStart;
            } else {
                $ranges[] = $rangeStart . ' đến ' . $prevTime;
            }
        }
        
        return $ranges;
    }

    /**
     * Search knowledge base for relevant content
     */
    protected function searchKnowledge(string $query, int $limit = 3): array
    {
        // Simple keyword-based search (no vector DB needed)
        $keywords = $this->extractKeywords($query);

        if (empty($keywords)) {
            return $this->getDefaultKnowledge();
        }

        $results = DB::table('ai_knowledge_items')
            ->where('is_active', true)
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('content', 'LIKE', "%{$keyword}%")
                        ->orWhere('title', 'LIKE', "%{$keyword}%");
                }
            })
            ->orderByRaw("
                CASE 
                    WHEN title LIKE ? THEN 1
                    WHEN content LIKE ? THEN 2
                    ELSE 3
                END
            ", ["%{$keywords[0]}%", "%{$keywords[0]}%"])
            ->limit($limit)
            ->get()
            ->toArray();

        return $results ?: $this->getDefaultKnowledge();
    }

    /**
     * Extract keywords from query
     */
    protected function extractKeywords(string $query): array
    {
        $stopWords = ['là', 'có', 'và', 'của', 'cho', 'này', 'đó', 'được', 'với', 'trong', 'để', 'bao', 'nhiêu', 'như', 'thế', 'nào', 'gì', 'sao', 'tôi', 'bạn', 'ở'];

        $words = preg_split('/\s+/', mb_strtolower($query));
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return mb_strlen($word) > 2 && !in_array($word, $stopWords);
        });

        return array_values($keywords);
    }

    /**
     * Get default knowledge for fallback
     */
    protected function getDefaultKnowledge(): array
    {
        return Cache::remember('ai_default_knowledge', 3600, function () {
            return DB::table('ai_knowledge_items')
                ->where('is_active', true)
                ->where('category', 'faq')
                ->limit(3)
                ->get()
                ->toArray();
        });
    }

    /**
     * Build prompt for LLM - request structured JSON response
     */
    protected function buildPrompt(string $query, array $context, array $history, array $dbContext = []): string
    {
        $contextText = '';
        foreach ($context as $item) {
            $contextText .= "- {$item->title}: {$item->content}\n\n";
        }

        if (empty($contextText)) {
            $contextText = "Không có thông tin cụ thể trong database.";
        }

        $historyText = '';
        foreach (array_slice($history, -6) as $msg) {
            $role = $msg['role'] === 'user' ? 'Khách' : 'Bot';
            $historyText .= "{$role}: {$msg['content']}\n";
        }

        // ✅ Build database context section
        $dbContextText = '';
        if (!empty($dbContext['courts'])) {
            $courts = $dbContext['courts'];
            $dbContextText .= "\n=== THÔNG TIN SÂN REALTIME ===\n";
            $dbContextText .= "Tổng số sân: {$courts['total']} sân\n";
            foreach ($courts['courts'] as $court) {
                $dbContextText .= "- {$court['name']}: Giá {$court['price']}, Thành viên {$court['member_price']}\n";
            }
        }

        if (!empty($dbContext['booking'])) {
            $booking = $dbContext['booking'];
            $dbContextText .= "\n=== KẾT QUẢ TRA CỨU ĐƠN ===\n";
            if ($booking['found']) {
                $dbContextText .= "✅ Mã đơn: {$booking['code']}\n";
                $dbContextText .= "Khách hàng: {$booking['customer_name']}\n";
                $dbContextText .= "Điện thoại: {$booking['phone']}\n";
                $dbContextText .= "Trạng thái: {$booking['status']}\n";
                $dbContextText .= "Tổng tiền: {$booking['total']}\n";
                $dbContextText .= "Số lượt đặt: {$booking['item_count']}\n";
                if (!empty($booking['items'])) {
                    $dbContextText .= "Chi tiết:\n";
                    foreach ($booking['items'] as $item) {
                        $dbContextText .= "  - {$item['court']}: {$item['date']} {$item['time']} - {$item['price']}\n";
                    }
                }
            } else {
                $dbContextText .= "❌ {$booking['message']}\n";
            }
        }

        // ✅ Add court availability context
        if (!empty($dbContext['availability'])) {
            $avail = $dbContext['availability'];
            $dbContextText .= "\n=== GIỜ TRỐNG CỦA SÂN ===\n";
            if ($avail['found']) {
                $dbContextText .= "🏸 {$avail['court_name']} - Ngày: {$avail['date']}\n";
                $dbContextText .= "Số khung giờ trống: {$avail['available_count']}\n";
                $dbContextText .= "Đã có: {$avail['booked_count']} lượt đặt\n";
                if (!empty($avail['available_slots'])) {
                    $dbContextText .= "Các khung giờ còn trống:\n";
                    foreach ($avail['available_slots'] as $slot) {
                        $dbContextText .= "  ✅ {$slot}\n";
                    }
                } else {
                    $dbContextText .= "❌ Đã hết giờ trống trong hôm nay\n";
                }
            } else {
                $dbContextText .= "❌ {$avail['message']}\n";
            }
        }

        // ✅ Add all courts availability context
        if (!empty($dbContext['all_availability'])) {
            $all = $dbContext['all_availability'];
            $dbContextText .= "\n=== TỔNG QUAN GIỜ TRỐNG HÔM NAY ===\n";
            $dbContextText .= "Ngày: {$all['date']}\n";
            foreach ($all['courts'] as $court) {
                $sampleSlots = implode(', ', $court['sample_slots']);
                $dbContextText .= "🏸 {$court['name']}: {$court['available_count']} khung giờ trống";
                if ($sampleSlots) {
                    $dbContextText .= " (VD: {$sampleSlots})";
                }
                $dbContextText .= "\n";
                // Show booked slots
                if (!empty($court['booked_details'])) {
                    $bookedStr = implode(', ', $court['booked_details']);
                    $dbContextText .= "   ⚠️ ĐÃ ĐẶT: {$bookedStr}\n";
                }
            }
        }

        // ✅ Add booking intent context
        if (!empty($dbContext['booking_intent'])) {
            $dbContextText .= "\n=== ĐANG TRONG CUỘC HỘI THOẠI ĐẶT SÂN ===\n";
            $dbContextText .= "QUAN TRỌNG: Khách hàng đang trong quy trình đặt sân qua chat!\n";
            if (!empty($dbContext['courts'])) {
                $courts = $dbContext['courts'];
                $dbContextText .= "Hiện có {$courts['total']} sân:\n";
                foreach ($courts['courts'] as $court) {
                    $dbContextText .= "- {$court['name']}: {$court['price']}/slot (30 phút)\n";
                }
            }
        }

        $todayDate = date('Y-m-d');
        $todayDisplay = date('d/m/Y');

        return <<<PROMPT
Bạn là trợ lý AI của Sân cầu lông Niên Thời - hệ thống đặt sân cầu lông.
Trả lời thân thiện, chuyên nghiệp bằng tiếng Việt.
Hôm nay là ngày: {$todayDisplay} ({$todayDate})

=== CÁC TRANG VÀ ACTIONS CÓ SẴN ===
Dựa vào câu hỏi của khách, hãy gợi ý TỐI ĐA 2 trang phù hợp:
1. san-gia: Xem sân & giá (icon: money) - khi hỏi về giá, danh sách sân
2. chinh-sach-huy-doi-hoan: Xem chính sách (icon: file-text) - khi hỏi về hủy/đổi/hoàn
3. danh-gia: Xem đánh giá (icon: star) - khi hỏi về review/đánh giá
4. tra-cuu: Tra cứu đơn (icon: search) - khi muốn kiểm tra đơn hàng
5. ve-chung-toi: Liên hệ (icon: info) - khi hỏi liên hệ/hotline

=== ĐẶT SÂN QUA CHAT (QUAN TRỌNG NHẤT) ===
Khi khách muốn đặt sân, bạn sẽ dẫn dắt quy trình ĐẶT SÂN HOÀN TOÀN QUA HỘI THOẠI theo các bước:

**BƯỚC 1: Khách nói "đặt sân" / "thuê sân" / "book sân"**
→ Kiểm tra thông tin sân trống bên dưới, TỰ GỢI Ý sân có giờ trống
→ Hỏi khách muốn đặt ngày nào và khung giờ nào (liệt kê vài giờ trống gợi ý)
→ KHÔNG cần hỏi khách chọn sân - tự gợi ý sân trống phù hợp nhất

**BƯỚC 2: Khách trả lời ngày + giờ** (ví dụ: "15:00-16:00" hoặc "3 giờ chiều")
→ Xác nhận sân + giờ + giá
→ Hỏi thông tin cá nhân: "Bạn vui lòng cho mình biết: Họ tên, Số điện thoại, và Email nhé!"

**BƯỚC 3: Khách gửi thông tin cá nhân** (tên, SĐT, email)
→ Parse thông tin từ tin nhắn (ví dụ: "Nguyễn Văn A, 0901234567, email@gmail.com")
→ Tổng hợp XÁC NHẬN toàn bộ thông tin đặt sân
→ PHẢI trả về cả "booking_data" trong JSON response
→ PHẢI thêm action: {"label": "💳 Thanh toán ngay", "url": "/thanh-toan", "icon": "calendar", "type": "primary"}

**CÁCH TRẢ booking_data (CHỈ Ở BƯỚC 3):**
Khi đã có ĐẦY ĐỦ: sân, ngày, giờ, tên, SĐT, email → thêm field "booking_data" vào JSON:
{
  "response": "✅ Xác nhận đặt sân thành công!\\n\\n🏸 Sân: [tên sân]\\n📅 Ngày: [ngày]\\n⏰ Giờ: [giờ bắt đầu] - [giờ kết thúc]\\n💰 Giá: [giá]đ\\n\\n👤 Họ tên: [tên]\\n📞 SĐT: [sđt]\\n📧 Email: [email]\\n\\nBấm nút bên dưới để thanh toán!",
  "actions": [{"label": "💳 Thanh toán ngay", "url": "/thanh-toan", "icon": "calendar", "type": "primary"}],
  "booking_data": {
    "court": "[tên sân]",
    "court_id": [id sân],
    "date": "[YYYY-MM-DD]",
    "start_time": "[HH:MM]",
    "end_time": "[HH:MM]",
    "price": [giá số nguyên],
    "customer_name": "[họ tên]",
    "phone": "[sđt]",
    "email": "[email]"
  }
}

**LƯU Ý QUAN TRỌNG:**
**LƯU Ý QUAN TRỌNG VỀ GIÁ TỀN:**
- Giá hiển thị ở trên là GIÁ MỖI SLOT 30 PHÚT, ví dụ: 70.000đ/slot
- 1 giờ = 2 slot = 70.000 x 2 = 140.000đ. 30 phút = 1 slot = 70.000đ
- NẾU KHÁCH CHỌN TỪ 4 SLOT (2 GIỜ) TRỞ LÊN: Giảm giá còn 120.000đ/giờ (tức 60.000đ/slot). (Giảm ~15%)
- Trong booking_data, price là TỔNG TIỀN = (giá/slot sau giảm/không giảm) x số slot
- Ví dụ 1: khách đặt 15:00-16:00 (2 slot) = 2 x 70.000 = 140.000đ
- Ví dụ 2: khách đặt 15:00-15:30 (1 slot) = 1 x 70.000 = 70.000đ
- Ví dụ 3: khách đặt 15:00-17:00 (4 slot) = 4 x 60.000 = 240.000đ (Đã áp dụng giảm giá 120k/giờ)

**LƯU Ý KHÁC:**
- Nếu khách chọn giờ đã bị đặt, thông báo và gợi ý giờ khác
- Tự chọn sân trống phù hợp nhất cho khách (ưu tiên sân có nhiều giờ trống)
- Khách có thể đặt cho NGÀY MAI hoặc ngày khác, không chỉ hôm nay
- Khi khách nói 'ngày mai', 'thứ 3' etc, kiểm tra thông tin sân trống theo ngày đó
- Nếu khách chỉ nói "chiều nay" hoặc "tối nay", gợi ý cụ thể giờ trống

=== FORMAT TRẢ LỜI (JSON) ===
BẮT BUỘC trả về JSON với format sau:
{
  "response": "Nội dung trả lời",
  "actions": [
    {"label": "Tên nút", "url": "/path", "icon": "icon-name", "type": "primary hoặc secondary"}
  ]
}
Thêm "booking_data" khi đã có đủ thông tin đặt sân (bước 3).

{$dbContextText}
=== THÔNG TIN SÂN ===
{$contextText}

=== LỊCH SỬ ===
{$historyText}

=== CÂU HỎI ===
Khách: {$query}

Trả lời (JSON):
PROMPT;
    }

    /**
     * Call LLM API
     */
    protected function callLLM(string $prompt): string
    {
        if (empty($this->apiKey)) {
            return $this->getMockResponse($prompt);
        }

        try {
            if ($this->provider === 'gemini') {
                return $this->callGemini($prompt);
            } else {
                return $this->callOpenAI($prompt);
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            \Log::error('AI Chat Error: ' . $errorMessage);
            
            // Parse specific errors for user-friendly messages
            if (str_contains($errorMessage, 'insufficient_quota')) {
                return 'Xin lỗi, API key OpenAI đã hết quota. Vui lòng liên hệ admin để nạp thêm credit hoặc đổi sang Gemini.';
            }
            if (str_contains($errorMessage, 'model_not_found') || str_contains($errorMessage, 'does not exist')) {
                return 'Xin lỗi, model AI đã chọn không khả dụng. Vui lòng vào Settings để chọn model khác.';
            }
            if (str_contains($errorMessage, 'invalid_api_key') || str_contains($errorMessage, 'Incorrect API key')) {
                return 'Xin lỗi, API key không hợp lệ. Vui lòng kiểm tra lại cài đặt.';
            }
            
            return 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau hoặc liên hệ hotline để được hỗ trợ.';
        }
    }

    /**
     * Call Google Gemini API
     */
    protected function callGemini(string $prompt): string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}", [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 1024,
                    ],
                ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Không thể tạo phản hồi.';
        }

        throw new \Exception('Gemini API error: ' . $response->body());
    }

    /**
     * Call OpenAI API
     */
    protected function callOpenAI(string $prompt): string
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'max_tokens' => 1024,
                    'temperature' => 0.7,
                ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['choices'][0]['message']['content'] ?? 'Không thể tạo phản hồi.';
        }

        throw new \Exception('OpenAI API error: ' . $response->body());
    }

    /**
     * Mock response when no API key
     */
    protected function getMockResponse(string $prompt): string
    {
        $prompt = mb_strtolower($prompt);

        if (str_contains($prompt, 'giá') || str_contains($prompt, 'bao nhiêu')) {
            return "👉 Giá thuê sân dao động từ 80.000đ - 150.000đ/giờ tùy khung giờ.\n👉 Giờ cao điểm (18h-21h) có giá cao hơn.\n👉 Thành viên được giảm 20% so với giá thường.\n\nBấm nút bên dưới để xem chi tiết bảng giá! 🏸";
        }

        if (str_contains($prompt, 'đặt') || str_contains($prompt, 'book') || str_contains($prompt, 'thuê') || str_contains($prompt, 'muốn đặt')) {
            return json_encode([
                'response' => "Tuyệt vời! Mình sẽ giúp bạn đặt sân ngay 🏸\n\nHiện tại chúng tôi có các sân trống hôm nay. Bạn muốn đặt ngày nào và khung giờ nào?\n\n👉 Ví dụ: \"Hôm nay, 15:00-16:00\" hoặc \"Ngày mai, 18:00-19:30\"\n\nSau khi chọn giờ, mình sẽ hỏi thông tin cá nhân để hoàn tất đặt sân nhé!",
                'actions' => [],
            ], JSON_UNESCAPED_UNICODE);
        }

        if (str_contains($prompt, 'hủy') || str_contains($prompt, 'hoàn') || str_contains($prompt, 'đổi')) {
            return "👉 Hủy trước 24h: Hoàn 100% tiền\n👉 Hủy trước 12h: Hoàn 50% tiền\n👉 Hủy dưới 12h: Không hoàn tiền\n👉 Đổi lịch: Miễn phí nếu còn chỗ trống\n\nBấm nút bên dưới để xem chi tiết chính sách!";
        }

        if (str_contains($prompt, 'chính sách')) {
            return "👉 Chính sách hủy linh hoạt, hoàn tiền theo thời gian báo trước\n👉 Đổi lịch miễn phí nếu báo trước 12h\n👉 Đảm bảo quyền lợi khách hàng\n\nBấm nút bên dưới để xem chi tiết!";
        }

        if (str_contains($prompt, 'tra cứu') || str_contains($prompt, 'đơn hàng') || str_contains($prompt, 'kiểm tra')) {
            return "👉 Bước 1: Nhập mã đơn hàng hoặc số điện thoại\n👉 Bước 2: Xem chi tiết đơn đặt sân\n👉 Bước 3: Kiểm tra trạng thái thanh toán\n\nBấm nút bên dưới để tra cứu!";
        }

        if (str_contains($prompt, 'danh sách sân') || str_contains($prompt, 'xem sân') || str_contains($prompt, 'có sân')) {
            return "👉 Chúng tôi có nhiều sân cầu lông chất lượng cao\n👉 Mặt sàn tiêu chuẩn thi đấu\n👉 Đèn chiếu sáng đầy đủ, điều hòa mát mẻ\n\nBấm nút bên dưới để xem danh sách sân và giá! 🏸";
        }

        if (str_contains($prompt, 'liên hệ') || str_contains($prompt, 'hotline')) {
            return "👉 Hotline: 1900-xxxx (8h-22h hàng ngày)\n👉 Email: support@sancaulongnienthoi.vn\n👉 Fanpage: facebook.com/sancaulongnienthoi\n\nChúng tôi luôn sẵn sàng hỗ trợ bạn! 📞";
        }

        if (str_contains($prompt, 'đánh giá') || str_contains($prompt, 'review')) {
            return "👉 Xem đánh giá từ khách hàng đã sử dụng dịch vụ\n👉 Chia sẻ trải nghiệm của bạn\n👉 Rating trung bình: 4.8/5 sao\n\nBấm nút bên dưới để xem tất cả đánh giá! ⭐";
        }

        return "Xin chào! Tôi có thể giúp bạn:\n👉 Thông tin về sân và giá cả\n👉 Hướng dẫn đặt sân\n👉 Chính sách hủy/đổi/hoàn\n👉 Tra cứu đơn hàng\n\nBạn muốn hỏi gì? 😊";
    }

    /**
     * Analyze a review using AI - dedicated method with detailed prompt and higher token limit.
     * This bypasses the chatbot wrapper for a focused analysis.
     */
    public function analyzeReview(array $reviewData): string
    {
        $prompt = <<<PROMPT
Phân tích đánh giá khách hàng sân cầu lông. Trả lời ngắn gọn, đúng trọng tâm bằng HTML (h4, ul, li, strong, p).

Khách: {$reviewData['customer_name']} | {$reviewData['rating']}/5 sao | Ngày: {$reviewData['date']}
Nội dung: {$reviewData['comment']}

Trả về đúng 3 phần:

<h4>📋 Vấn đề chính</h4>
- Liệt kê vấn đề, mức độ nghiêm trọng (Cao/TB/Thấp)

<h4>💡 Giải pháp cho chủ sân</h4>
- 3 giải pháp cụ thể, khả thi, sắp theo ưu tiên

<h4>✉️ Mẫu phản hồi khách hàng</h4>
- Viết phản hồi ngắn, chuyên nghiệp, thể hiện đồng cảm, mời khách quay lại

Chỉ trả HTML thuần, không markdown, không code block.
PROMPT;

        if (empty($this->apiKey)) {
            return $this->getMockReviewAnalysis($reviewData);
        }

        try {
            if ($this->provider === 'gemini') {
                return $this->callGeminiForAnalysis($prompt);
            } else {
                return $this->callOpenAIForAnalysis($prompt);
            }
        } catch (\Exception $e) {
            \Log::error('AI Review Analysis Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Call Gemini API with higher token limit for review analysis
     */
    protected function callGeminiForAnalysis(string $prompt): string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}", [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 2048,
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            // Clean up: remove markdown code blocks if AI wraps in them
            $text = preg_replace('/^```html\s*/s', '', $text);
            $text = preg_replace('/```\s*$/s', '', $text);
            return trim($text);
        }

        throw new \Exception('Gemini API error: ' . $response->body());
    }

    /**
     * Call OpenAI API with higher token limit for review analysis
     */
    protected function callOpenAIForAnalysis(string $prompt): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là chuyên gia phân tích đánh giá khách hàng. Trả lời bằng HTML thuần.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 4096,
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['choices'][0]['message']['content'] ?? '';
            $text = preg_replace('/^```html\s*/s', '', $text);
            $text = preg_replace('/```\s*$/s', '', $text);
            return trim($text);
        }

        throw new \Exception('OpenAI API error: ' . $response->body());
    }

    /**
     * Mock response for review analysis when no API key is configured
     */
    protected function getMockReviewAnalysis(array $reviewData): string
    {
        return '<h4>📋 Tóm tắt vấn đề</h4>
        <p>Khách hàng <strong>' . htmlspecialchars($reviewData['customer_name']) . '</strong> đánh giá <strong>' . $reviewData['rating'] . '/5 sao</strong>.</p>
        <ul>
            <li><strong>Mức độ nghiêm trọng:</strong> ' . ($reviewData['rating'] <= 2 ? 'Cao' : 'Trung bình') . '</li>
            <li><strong>Nội dung:</strong> ' . htmlspecialchars($reviewData['comment']) . '</li>
        </ul>
        <h4>💡 Giải pháp đề xuất</h4>
        <p><em>(Đang chạy ở chế độ demo - Vui lòng cấu hình API key để nhận phân tích chi tiết từ AI)</em></p>
        <ul>
            <li>Kiểm tra và nâng cấp cơ sở vật chất sân</li>
            <li>Đào tạo nhân viên về dịch vụ khách hàng</li>
            <li>Liên hệ trực tiếp khách hàng để xin lỗi và đề xuất bù đắp</li>
        </ul>
        <h4>✉️ Gợi ý phản hồi</h4>
        <p><em>(Cần API key để tạo phản hồi tự động)</em></p>';
    }
}
