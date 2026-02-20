{{-- AI Chatbot Widget --}}
@if(setting('ai_chatbot_enabled', true))
    <div id="chatbot-widget">
        {{-- Chat Button --}}
        <button class="chat-btn" id="chatToggle" aria-label="Mở hỗ trợ AI">
            <svg class="chat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
            </svg>
        </button>

        {{-- Chat Window --}}
        <div class="chat-window" id="chatWindow">
            {{-- Header --}}
            <div class="chat-header">
                <div class="chat-brand">
                    <div class="brand-avatar">B</div>
                    <div class="brand-info">
                        <span class="brand-name">Sân cầu lông Niên Thời</span>
                        <span class="brand-status">
                            <span class="status-dot"></span>
                            Online - Sẵn sàng hỗ trợ
                        </span>
                    </div>
                </div>
                <button class="chat-close" id="chatClose" aria-label="Đóng">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Messages --}}
            <div class="chat-messages" id="chatMessages">
                {{-- Welcome message --}}
                <div class="message bot">
                    <div class="message-avatar">B</div>
                    <div class="message-content">
                        <div class="message-bubble">@if(auth('member')->check()) Xin chào {{ auth('member')->user()->first_name ?: auth('member')->user()->name }}! Bạn cần giúp gì không? @else Xin chào! Chào bạn! @endif</div>
                        <div class="message-time">Bot • Vừa xong</div>
                    </div>
                </div>

                {{-- Quick Replies --}}
                <div class="quick-replies" id="quickReplies">
                    <button type="button" class="quick-reply" data-message="Làm sao để đặt sân?">Làm sao để đặt sân?</button>
                    <button type="button" class="quick-reply" data-message="Giá thuê sân bao nhiêu?">Giá thuê sân bao nhiêu?</button>
                    <button type="button" class="quick-reply" data-message="Ưu đãi khách cố định?">Ưu đãi khách cố định?</button>
                    <button type="button" class="quick-reply" data-message="Có bao nhiêu sân?">Có bao nhiêu sân?</button>
                </div>
            </div>

            {{-- Typing Indicator --}}
            <div class="typing-indicator" id="typingIndicator" style="display:none;">
                <div class="message-avatar">B</div>
                <div class="typing-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>

            {{-- Input --}}
            <div class="chat-input">
                <input type="text" id="chatInput" placeholder="Nhập tin nhắn..." autocomplete="off">
                <button class="send-btn" id="sendBtn" aria-label="Gửi">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <style>
        /* ===== CHATBOT WIDGET STYLES ===== */
        #chatbot-widget {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Chat Button */
        .chat-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a5a45 0%, #0f3d2e 100%);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(26, 90, 69, 0.4);
            transition: all 0.3s ease;
            position: relative;
        }

        .chat-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 28px rgba(26, 90, 69, 0.5);
        }

        .chat-btn .chat-icon {
            width: 28px;
            height: 28px;
            color: white;
        }

        /* Chat Window */
        .chat-window {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 380px;
            height: 560px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
            animation: slideUp 0.3s ease;
        }

        .chat-window.open {
            display: flex;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .chat-header {
            background: linear-gradient(135deg, #1a5a45 0%, #0f3d2e 100%);
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-avatar {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .brand-info {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .brand-status {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .chat-close {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .chat-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .chat-close svg {
            width: 18px;
            height: 18px;
            color: white;
        }

        /* Messages */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .message {
            display: flex;
            gap: 10px;
            max-width: 85%;
        }

        .message.user {
            flex-direction: row-reverse;
            align-self: flex-end;
        }

        .message.bot {
            align-self: flex-start;
        }

        .message.staff {
            align-self: flex-start;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            background: #1a5a45;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 12px;
            flex-shrink: 0;
        }

        .staff-avatar {
            background: #16a34a !important;
        }

        .message-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
            max-width: 100%;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .message.bot .message-bubble {
            background: #f3f4f6;
            color: #1f2937;
            border-bottom-left-radius: 4px;
        }

        .message.user .message-bubble {
            background: #1a5a45;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .staff-bubble {
            background: #dcfce7 !important;
            color: #166534 !important;
            border-bottom-left-radius: 4px;
        }

        .message-time {
            font-size: 11px;
            color: #9ca3af;
            padding: 0 8px;
        }

        .message.user .message-time {
            text-align: right;
        }

        .staff-name {
            color: #16a34a;
            font-weight: 500;
        }

        .status-dot.live {
            background: #22c55e;
        }

        /* Quick Replies */
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 0 8px;
        }

        .quick-reply {
            padding: 10px 16px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            font-size: 13px;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-reply:hover {
            border-color: #1a5a45;
            color: #1a5a45;
            background: #f0fdf4;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: flex;
            gap: 10px;
            padding: 0 20px 16px;
        }

        .typing-dots {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 12px 16px;
            background: #f3f4f6;
            border-radius: 18px;
        }

        .typing-dots span {
            width: 8px;
            height: 8px;
            background: #9ca3af;
            border-radius: 50%;
            animation: bounce 1.4s infinite;
        }

        .typing-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-4px);
            }
        }

        /* Input */
        .chat-input {
            padding: 16px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 12px;
            background: white;
        }

        .chat-input input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .chat-input input:focus {
            border-color: #1a5a45;
        }

        .send-btn {
            width: 44px;
            height: 44px;
            background: #1a5a45;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .send-btn:hover {
            background: #0f3d2e;
            transform: scale(1.05);
        }

        .send-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        .send-btn svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .chat-window {
                width: calc(100vw - 32px);
                height: calc(100vh - 120px);
                right: -8px;
            }
        }

        /* Action Buttons - VCB Digibot Style */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 12px;
            padding: 0 4px;
        }

        .action-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 24px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: 2px solid #1a5a45;
            background: white;
            color: #1a5a45;
        }

        .action-button:hover {
            background: #1a5a45;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 90, 69, 0.3);
        }

        .action-button.primary {
            background: linear-gradient(135deg, #1a5a45 0%, #0f3d2e 100%);
            color: white;
            border-color: transparent;
        }

        .action-button.primary:hover {
            background: linear-gradient(135deg, #0f3d2e 0%, #0a2920 100%);
            box-shadow: 0 4px 16px rgba(26, 90, 69, 0.4);
        }

        .action-button svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* Format for multi-line bot messages with steps */
        .message-bubble {
            white-space: pre-line;
        }

        /* ===== BOOKING TRIGGER STYLE ===== */
        .booking-trigger {
            background: linear-gradient(135deg, #1a5a45, #22c55e) !important;
            color: white !important;
            border: none !important;
        }
    </style>
    <script>
        (function () {
            'use strict';

            // Configuration - use Laravel API
            const API_URL = '{{ url("/api/chatbot/chat") }}';
            const POLL_URL = '{{ url("/api/chatbot/poll") }}';
            const SESSION_KEY = 'chatbot_session';
            const CSRF_TOKEN = '{{ csrf_token() }}';

            // Elements
            const toggle = document.getElementById('chatToggle');
            const chatWindow = document.getElementById('chatWindow');
            const close = document.getElementById('chatClose');
            const messagesContainer = document.getElementById('chatMessages');
            const input = document.getElementById('chatInput');
            const sendBtn = document.getElementById('sendBtn');
            const typing = document.getElementById('typingIndicator');
            const quickReplies = document.getElementById('quickReplies');
            const brandStatus = document.querySelector('.brand-status');

            // State
            let sessionId = localStorage.getItem(SESSION_KEY);
            let history = [];
            let isLoading = false;
            let isLive = false;
            let pollInterval = null;
            let serverMessageCount = 0; // Track server-side count
            let localMessages = []; // Store all messages locally
            let lastQuery = ''; // Store last query for action tracking

            // Booking state (managed by AI conversation, stored in localStorage)

            // Generate session ID
            if (!sessionId) {
                sessionId = 'session_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
                localStorage.setItem(SESSION_KEY, sessionId);
            }

            // Isolate chatbot widget from any external click handlers that may cause redirects
            const chatWidget = document.getElementById('chatbot-widget');
            if (chatWidget) {
                chatWidget.addEventListener('click', (e) => {
                    // Prevent clicks inside chatbot from bubbling to external handlers
                    e.stopPropagation();
                }, false);
            }

            // Toggle chat window
            toggle.addEventListener('click', () => {
                chatWindow.classList.add('open');
                toggle.style.display = 'none';
                input.focus();
                startPolling();
            });

            close.addEventListener('click', () => {
                chatWindow.classList.remove('open');
                toggle.style.display = 'flex';
                stopPolling();
            });

            // Polling for new messages (especially staff)
            function startPolling() {
                if (pollInterval) return;
                pollMessages(); // Poll immediately
                pollInterval = setInterval(pollMessages, 1500); // Poll every 1.5s
            }

            function stopPolling() {
                if (pollInterval) {
                    clearInterval(pollInterval);
                    pollInterval = null;
                }
            }

            async function pollMessages() {
                try {
                    const response = await fetch(`${POLL_URL}/${sessionId}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await response.json();

                    if (data.success && data.messages) {
                        // Update live status
                        if (data.is_live !== isLive) {
                            isLive = data.is_live;
                            updateStatusIndicator();
                        }

                        // Check for new messages by comparing count
                        if (data.messages.length > serverMessageCount) {
                            // Find new messages
                            const newMessages = data.messages.slice(serverMessageCount);
                            newMessages.forEach(msg => {
                                // Skip if already displayed locally (compare content for user messages)
                                const isDuplicate = localMessages.some(m => 
                                    (m.role === msg.role && m.content === msg.content) ||
                                    (m.time === msg.time && m.content === msg.content)
                                );
                                if (!isDuplicate) {
                                    localMessages.push(msg);
                                    displayMessage(msg);
                                }
                            });
                            serverMessageCount = data.messages.length;
                        }
                    }
                } catch (e) {
                    console.log('Poll error:', e);
                }
            }

            function displayMessage(msg) {
                const div = document.createElement('div');

                if (msg.role === 'user') {
                    div.className = 'message user';
                    div.innerHTML = `
                                    <div class="message-content">
                                        <div class="message-bubble">${escapeHtml(msg.content)}</div>
                                        <div class="message-time">Bạn • ${formatTime(msg.time)}</div>
                                    </div>
                                `;
                } else if (msg.role === 'staff') {
                    div.className = 'message staff';
                    div.innerHTML = `
                                    <div class="message-avatar staff-avatar">NV</div>
                                    <div class="message-content">
                                        <div class="message-bubble staff-bubble">${escapeHtml(msg.content)}</div>
                                        <div class="message-time staff-name">${msg.staff_name || 'Nhân viên'} • ${formatTime(msg.time)}</div>
                                    </div>
                                `;
                } else { // assistant/bot
                    div.className = 'message bot';
                    const actionsHtml = renderActionButtons(msg.actions || []);
                    div.innerHTML = `
                                    <div class="message-avatar">B</div>
                                    <div class="message-content">
                                        <div class="message-bubble">${escapeHtml(msg.content)}</div>
                                        ${actionsHtml}
                                        <div class="message-time">Trợ lý AI • ${formatTime(msg.time)}</div>
                                    </div>
                                `;
                }

                messagesContainer.appendChild(div);
                scrollToBottom();
            }

            // Render action buttons HTML
            function renderActionButtons(actions) {
                if (!actions || actions.length === 0) return '';
                
                const icons = {
                    'calendar': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
                    'money': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                    'list': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>',
                    'file-text': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
                    'search': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
                    'star': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
                    'info': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
                    'phone': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
                    'check-circle': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
                    'refresh': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>',
                    'box': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
                };

                const buttonsHtml = actions.map(action => {
                    const iconSvg = icons[action.icon] || icons['info'];
                    const typeClass = action.type === 'primary' ? 'primary' : '';
                    return `<a href="${action.url}" class="action-button ${typeClass}" target="_self">${iconSvg}${action.label}</a>`;
                }).join('');

                return `<div class="action-buttons">${buttonsHtml}</div>`;
            }

            function formatTime(timeStr) {
                if (!timeStr) return 'Vừa xong';
                try {
                    return new Date(timeStr).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
                } catch {
                    return 'Vừa xong';
                }
            }

            // Track action button click for learning
            async function trackActionClick(actionUrl, actionLabel) {
                if (!lastQuery) return; // No query to track
                
                try {
                    await fetch('/api/chatbot/track-action', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            session_id: sessionId,
                            query: lastQuery,
                            action_url: actionUrl,
                            action_label: actionLabel,
                        }),
                    });
                } catch (e) {
                    // Silently fail - don't break user experience
                }
            }

            // Event delegation for action buttons
            messagesContainer.addEventListener('click', (e) => {
                const actionBtn = e.target.closest('.action-button');
                if (actionBtn) {
                    const actionUrl = actionBtn.getAttribute('href');
                    const actionLabel = actionBtn.textContent.trim();
                    // Track the click (non-blocking)
                    trackActionClick(actionUrl, actionLabel);
                    // Let the default navigation happen
                }
            });

            function updateStatusIndicator() {
                if (brandStatus) {
                    if (isLive) {
                        brandStatus.innerHTML = `
                                        <span class="status-dot live"></span>
                                        Nhân viên hỗ trợ
                                    `;
                    } else {
                        brandStatus.innerHTML = `
                                        <span class="status-dot"></span>
                                        Sẵn sàng hỗ trợ
                                    `;
                    }
                }
            }

            // Send message via AJAX
            async function sendMessage(text) {
                if (!text.trim() || isLoading) return;

                // ===== REFRESH CHAT HANDLER =====
                const cleanText = text.trim().toLowerCase().replace(/[.,!?]/g, '');
                const refreshKeywords = ['làm mới', 'lam moi', 'reset chat', 'xóa chat', 'xoa chat', 'làm mới đoạn chat', 'lam moi doan chat', 'clear chat', 'bắt đầu lại', 'bat dau lai'];
                if (refreshKeywords.some(kw => cleanText.includes(kw))) {
                    input.value = '';
                    // Clear UI messages
                    messagesContainer.innerHTML = '';
                    // Reset state
                    history = [];
                    localMessages = [];
                    serverMessageCount = 0;
                    isLive = false;
                    updateStatusIndicator();
                    // Generate new session
                    sessionId = 'session_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
                    localStorage.setItem(SESSION_KEY, sessionId);
                    // Show fresh welcome message
                    const welcomeMsg = {
                        role: 'assistant',
                        content: '🔄 Đoạn chat đã được làm mới!\n\nXin chào! Tôi là trợ lý AI của Sân cầu lông Niên Thời. Tôi có thể giúp bạn:\n• Đặt sân cầu lông\n• Xem giá sân và khung giờ\n• Tìm hiểu dịch vụ\n• Hỗ trợ thanh toán\n\nBạn cần hỗ trợ gì ạ?',
                        time: new Date().toISOString()
                    };
                    localMessages.push(welcomeMsg);
                    displayMessage(welcomeMsg);
                    // Show quick replies again
                    if (quickReplies) quickReplies.style.display = 'flex';
                    return;
                }
                // ===== END REFRESH CHAT =====

                isLoading = true;
                sendBtn.disabled = true;
                input.value = '';

                // Save last query for action tracking
                lastQuery = text;

                // Add to history
                history.push({ role: 'user', content: text });

                // ✅ Show user message IMMEDIATELY (optimistic UI)
                const userMsg = {
                    role: 'user',
                    content: text,
                    time: new Date().toISOString()
                };
                localMessages.push(userMsg); // Track to avoid duplicates
                displayMessage(userMsg);

                // Hide quick replies after first message
                hideQuickReplies();

                // Show typing indicator AFTER user message
                typing.style.display = 'flex';
                scrollToBottom();

                try {
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            message: text,
                            session_id: sessionId,
                            history: history.slice(-6),
                        }),
                    });

                    const data = await response.json();

                    // ✅ Hide typing IMMEDIATELY when response is received
                    typing.style.display = 'none';

                    if (data.success) {
                        if (data.is_live) {
                            isLive = true;
                            updateStatusIndicator();
                            // Show system message
                            const sysDiv = document.createElement('div');
                            sysDiv.className = 'message system';
                            sysDiv.innerHTML = `
                                    <div class="message-content" style="text-align: center; width: 100%;">
                                        <div class="message-bubble" style="background: #fef3c7; color: #92400e; font-size: 13px; padding: 8px 12px;">Nhân viên sẽ phản hồi bạn ngay!</div>
                                    </div>
                                `;
                            messagesContainer.appendChild(sysDiv);
                        }

                        // ✅ Display bot response DIRECTLY instead of waiting for poll
                        if (data.response) {
                            const botMsg = {
                                role: 'assistant',
                                content: data.response,
                                actions: data.actions || [],
                                time: new Date().toISOString()
                            };
                            localMessages.push(botMsg);
                            displayMessage(botMsg);
                            
                            // Add to history
                            history.push({ role: 'assistant', content: data.response });
                        }

                        // ✅ Handle booking_data from AI → save to localStorage for checkout page
                        if (data.booking_data) {
                            handleBookingData(data.booking_data);
                        }
                        
                        // Update server message count to avoid duplicates from polling
                        serverMessageCount += 2; // user + bot messages
                    } else {
                        // Show specific error message from backend (e.g. 409 Conflict)
                        const errorMsg = data.message || 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.';
                        const errDiv = document.createElement('div');
                        errDiv.className = 'message bot';
                        errDiv.innerHTML = `
                                            <div class="message-avatar">B</div>
                                            <div class="message-content">
                                                <div class="message-bubble">${errorMsg}</div>
                                                <div class="message-time">AI Bot • Vừa xong</div>
                                            </div>
                                        `;
                        messagesContainer.appendChild(errDiv);
                    }
                } catch (error) {
                    console.error('Chat error:', error);
                    typing.style.display = 'none'; // Also hide on error
                    const errDiv = document.createElement('div');
                    errDiv.className = 'message bot';
                    errDiv.innerHTML = `
                                        <div class="message-avatar">B</div>
                                        <div class="message-content">
                                            <div class="message-bubble">Không thể kết nối. Vui lòng thử lại sau.</div>
                                            <div class="message-time">AI Bot • Vừa xong</div>
                                        </div>
                                    `;
                    messagesContainer.appendChild(errDiv);
                }

                isLoading = false;
                sendBtn.disabled = false;
                hideQuickReplies();
                scrollToBottom();
            }

            // Event listeners
            sendBtn.addEventListener('click', () => sendMessage(input.value));

            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !isLoading) {
                    sendMessage(input.value);
                }
            });

            // Quick replies - block ALL propagation to prevent any other handlers
            quickReplies.addEventListener('click', (e) => {
                if (e.target.classList.contains('quick-reply')) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    sendMessage(e.target.dataset.message);
                }
            }, true);
            
            // Also add mousedown handler to prevent any mouse-based redirects
            quickReplies.addEventListener('mousedown', (e) => {
                if (e.target.classList.contains('quick-reply')) {
                    e.stopPropagation();
                }
            }, true);

            // ===== AI BOOKING DATA HANDLER =====
            // When AI returns booking_data (step 3 of conversation), save to localStorage
            // so the checkout page (/thanh-toan) can display the booking details
            function handleBookingData(bookingData) {
                try {
                    // Save personal info for checkout page
                    const personalInfo = {
                        field_1: bookingData.customer_name || '',
                        field_2: bookingData.email || '',
                        field_3: bookingData.phone || '',
                    };
                    localStorage.setItem('personalInfo', JSON.stringify(personalInfo));

                    // Generate individual 30-min slot items
                    // Checkout page expects each item.time = "HH:MM" (start time of a 30-min slot)
                    // and auto-calculates end_time = start + 30 min
                    const bookingItems = [];
                    const startTime = bookingData.start_time || '';
                    const endTime = bookingData.end_time || '';
                    const totalPrice = bookingData.price || 0;

                    if (startTime && endTime) {
                        // Parse times to calculate number of 30-min slots
                        const [sh, sm] = startTime.split(':').map(Number);
                        const [eh, em] = endTime.split(':').map(Number);
                        const startMinutes = sh * 60 + sm;
                        const endMinutes = eh * 60 + em;
                        const numSlots = Math.max(1, Math.round((endMinutes - startMinutes) / 30));
                        const pricePerSlot = Math.round(totalPrice / numSlots);

                        for (let i = 0; i < numSlots; i++) {
                            const slotStartMin = startMinutes + (i * 30);
                            const slotH = String(Math.floor(slotStartMin / 60)).padStart(2, '0');
                            const slotM = String(slotStartMin % 60).padStart(2, '0');
                            const slotTime = slotH + ':' + slotM;

                            bookingItems.push({
                                court: bookingData.court || '',
                                court_id: bookingData.court_id || null,
                                court_name: bookingData.court || '',
                                date: bookingData.date || '',
                                time: slotTime,
                                price: pricePerSlot,
                            });
                        }
                    } else {
                        // Fallback: single item
                        bookingItems.push({
                            court: bookingData.court || '',
                            court_id: bookingData.court_id || null,
                            court_name: bookingData.court || '',
                            date: bookingData.date || '',
                            time: startTime,
                            price: totalPrice,
                        });
                    }

                    localStorage.setItem('tempBooking', JSON.stringify(bookingItems));

                    // Save customer type as casual (chatbot user)
                    localStorage.setItem('customerData', JSON.stringify({ customerType: 'casual' }));

                    console.log('[CHATBOT] Booking data saved to localStorage:', { personalInfo, bookingItems });
                } catch (e) {
                    console.error('[CHATBOT] Error saving booking data:', e);
                }
            }

            // ===== END AI BOOKING =====


            function hideQuickReplies() {
                if (quickReplies) {
                    quickReplies.style.display = 'none';
                }
            }

            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        })();
    </script>
@endif