@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row g-3">
        {{-- Sessions List --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="ti ti-messages me-2"></i>Cuộc chat
                    </h3>
                    <span class="badge bg-primary ms-auto" id="sessionCount">0</span>
                    <span class="badge bg-success-lt ms-2" id="pollingStatus">● Live</span>
                </div>
                <div class="list-group list-group-flush overflow-auto" id="sessionList" style="max-height: 70vh;">
                    <div class="text-center py-4 text-muted" id="noSessions">
                        <i class="ti ti-inbox" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Chưa có cuộc chat nào</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chat Panel --}}
        <div class="col-md-8">
            <div class="card h-100" id="chatPanel" style="display: none;">
                {{-- Header --}}
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-primary-lt me-3" id="chatAvatar">K</span>
                        <div>
                            <h4 class="mb-0" id="chatCustomerName">Khách hàng</h4>
                            <small class="text-muted" id="chatSessionId"></small>
                        </div>
                    </div>
                    <div class="ms-auto d-flex gap-2">
                        <button class="btn btn-success" id="takeoverBtn" onclick="toggleTakeover(true)">
                            <i class="ti ti-user-check me-1"></i>Tiếp quản
                        </button>
                        <button class="btn btn-outline-secondary" id="releaseBtn" onclick="toggleTakeover(false)"
                            style="display: none;">
                            <i class="ti ti-robot me-1"></i>Trả lại AI
                        </button>
                    </div>
                </div>

                {{-- Messages --}}
                <div class="card-body p-0 overflow-auto" id="chatMessages" style="height: 50vh; background: #f8f9fa;">
                </div>

                {{-- Input (only when takeover) --}}
                <div class="card-footer" id="chatInput" style="display: none;">
                    <div class="input-group">
                        <input type="text" class="form-control" id="messageInput" placeholder="Nhập tin nhắn..." />
                        <button class="btn btn-primary" onclick="sendMessage()">
                            <i class="ti ti-send me-1"></i>Gửi
                        </button>
                    </div>
                </div>
            </div>

            {{-- Empty State --}}
            <div class="card h-100" id="emptyPanel">
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 60vh;">
                    <div class="text-center text-muted">
                        <i class="ti ti-message-2" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">Chọn một cuộc chat</h4>
                        <p>Click vào cuộc chat bên trái để xem chi tiết và phản hồi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .session-item {
            cursor: pointer;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .session-item:hover {
            background: #f8f9fa;
        }

        .session-item.active {
            background: #e7f1ff !important;
            border-left: 3px solid var(--tblr-primary);
        }

        .session-item.has-new {
            background: #fff3cd;
        }

        .badge-live {
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

        .chat-bubble {
            max-width: 75%;
            word-wrap: break-word;
        }

        .chat-bubble.user {
            background: #e5e7eb;
            border-radius: 18px 18px 4px 18px;
        }

        .chat-bubble.bot {
            background: #228be6;
            color: white;
            border-radius: 18px 18px 18px 4px;
        }

        .chat-bubble.staff {
            background: #40c057;
            color: white;
            border-radius: 18px 18px 18px 4px;
        }
    </style>

    <script>
        const API_BASE = '{{ url("/admin/api/live-chat") }}';
        const CSRF = '{{ csrf_token() }}';

        // State
        let currentSessionId = null;
        let isLive = false;
        let sessionsData = {};
        let lastMessageCount = 0;

        // Start polling immediately
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Live Chat Dashboard loaded');
            loadSessions();

            // Poll sessions every 2 seconds
            setInterval(loadSessions, 2000);
        });

        async function loadSessions() {
            try {
                const res = await fetch(`${API_BASE}/sessions`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();

                document.getElementById('pollingStatus').textContent = '● Live';

                if (data.success && data.sessions && data.sessions.length > 0) {
                    document.getElementById('noSessions').style.display = 'none';
                    document.getElementById('sessionCount').textContent = data.sessions.length;
                    renderSessions(data.sessions);

                    // Auto-refresh current chat messages
                    if (currentSessionId) {
                        const currentSession = data.sessions.find(s => s.session_id === currentSessionId);
                        if (currentSession && currentSession.message_count > lastMessageCount) {
                            loadMessages();
                            lastMessageCount = currentSession.message_count;
                        }
                    }
                } else {
                    document.getElementById('noSessions').style.display = 'block';
                    document.getElementById('sessionCount').textContent = '0';
                    document.getElementById('sessionList').querySelectorAll('.session-item').forEach(el => el.remove());
                }
            } catch (e) {
                console.error('Load sessions error:', e);
                document.getElementById('pollingStatus').textContent = '○ Offline';
            }
        }

        function renderSessions(sessions) {
            const list = document.getElementById('sessionList');

            // Track existing items
            const existingIds = new Set();
            list.querySelectorAll('.session-item').forEach(el => {
                existingIds.add(el.getAttribute('data-session'));
            });

            sessions.forEach(s => {
                let item = list.querySelector(`[data-session="${s.session_id}"]`);
                const isNew = !item;
                const hadUpdate = sessionsData[s.session_id] &&
                    sessionsData[s.session_id].message_count < s.message_count;

                if (!item) {
                    item = document.createElement('div');
                    item.className = 'list-group-item session-item';
                    item.setAttribute('data-session', s.session_id);
                    item.onclick = () => selectSession(s);
                    list.insertBefore(item, list.firstChild);
                }

                // Mark as having new messages
                if (hadUpdate && s.session_id !== currentSessionId) {
                    item.classList.add('has-new');
                }

                const lastMsgPreview = s.last_message ? s.last_message.substring(0, 35) + '...' : 'Không có tin nhắn';
                const roleIcon = s.last_role === 'user' ? '👤' : (s.last_role === 'staff' ? '👨‍💼' : '🤖');

                item.innerHTML = `
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-sm bg-${s.is_live ? 'success' : 'secondary'}-lt me-2">
                                ${s.customer_name.charAt(0).toUpperCase()}
                            </span>
                            <div class="flex-fill overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>${s.customer_name}</strong>
                                    ${s.is_live ? '<span class="badge bg-success badge-live">Live</span>' : ''}
                                </div>
                                <div class="text-muted small text-truncate">
                                    ${roleIcon} ${lastMsgPreview}
                                </div>
                            </div>
                            <span class="badge bg-primary-lt ms-2">${s.message_count}</span>
                        </div>
                    `;

                if (s.session_id === currentSessionId) {
                    item.classList.add('active');
                    item.classList.remove('has-new');
                }

                // Store session data for comparison
                sessionsData[s.session_id] = s;
                existingIds.delete(s.session_id);
            });

            // Remove sessions that no longer exist
            existingIds.forEach(id => {
                const el = list.querySelector(`[data-session="${id}"]`);
                if (el) el.remove();
            });
        }

        async function selectSession(session) {
            // Clear previous
            document.querySelectorAll('.session-item').forEach(el => {
                el.classList.remove('active');
                el.classList.remove('has-new');
            });
            document.querySelector(`[data-session="${session.session_id}"]`)?.classList.add('active');

            currentSessionId = session.session_id;
            lastMessageCount = session.message_count;

            // Show chat panel
            document.getElementById('emptyPanel').style.display = 'none';
            document.getElementById('chatPanel').style.display = 'flex';
            document.getElementById('chatPanel').classList.add('flex-column');

            // Update header
            document.getElementById('chatCustomerName').textContent = session.customer_name;
            document.getElementById('chatSessionId').textContent = session.session_id.substring(0, 20) + '...';
            document.getElementById('chatAvatar').textContent = session.customer_name.charAt(0).toUpperCase();

            // Load messages immediately
            await loadMessages();
        }

        async function loadMessages() {
            if (!currentSessionId) return;

            try {
                const res = await fetch(`${API_BASE}/messages/${currentSessionId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();

                if (data.success) {
                    isLive = data.is_live;
                    renderMessages(data.messages || []);
                    updateTakeoverUI();
                }
            } catch (e) {
                console.error('Load messages error:', e);
            }
        }

        function renderMessages(messages) {
            const container = document.getElementById('chatMessages');
            const wasAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 50;

            container.innerHTML = '';

            messages.forEach(msg => {
                const div = document.createElement('div');
                div.className = `d-flex p-3 ${msg.role === 'user' ? 'justify-content-end' : ''}`;

                let bubbleClass = msg.role === 'user' ? 'user' : (msg.role === 'staff' ? 'staff' : 'bot');
                let label = msg.role === 'user' ? 'Khách' : (msg.role === 'staff' ? (msg.staff_name || 'Nhân viên') : 'AI Bot');
                let time = msg.time ? new Date(msg.time).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }) : '';

                div.innerHTML = `
                        <div class="chat-bubble ${bubbleClass} p-3">
                            <div class="small ${msg.role === 'user' ? 'text-muted' : 'opacity-75'} mb-1">${label} ${time}</div>
                            ${escapeHtml(msg.content)}
                        </div>
                    `;
                container.appendChild(div);
            });

            // Scroll to bottom if was at bottom
            if (wasAtBottom) {
                container.scrollTop = container.scrollHeight;
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function updateTakeoverUI() {
            document.getElementById('takeoverBtn').style.display = isLive ? 'none' : 'inline-flex';
            document.getElementById('releaseBtn').style.display = isLive ? 'inline-flex' : 'none';
            document.getElementById('chatInput').style.display = isLive ? 'block' : 'none';

            if (isLive) {
                document.getElementById('messageInput').focus();
            }
        }

        async function toggleTakeover(live) {
            if (!currentSessionId) return;

            try {
                const res = await fetch(`${API_BASE}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ session_id: currentSessionId, is_live: live }),
                });

                const data = await res.json();
                if (data.success) {
                    isLive = live;
                    updateTakeoverUI();
                    loadSessions(); // Refresh session list
                }
            } catch (e) {
                console.error('Toggle error:', e);
            }
        }

        async function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            if (!message || !currentSessionId) return;

            const btn = document.querySelector('#chatInput button');
            btn.disabled = true;
            input.disabled = true;

            try {
                const res = await fetch(`${API_BASE}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ session_id: currentSessionId, message }),
                });

                if (res.ok) {
                    input.value = '';
                    await loadMessages();
                    await loadSessions();
                } else {
                    alert('Lỗi gửi tin nhắn!');
                }
            } catch (e) {
                console.error('Send error:', e);
                alert('Lỗi kết nối!');
            }

            btn.disabled = false;
            input.disabled = false;
            input.focus();
        }

        document.getElementById('messageInput')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    </script>
@endsection