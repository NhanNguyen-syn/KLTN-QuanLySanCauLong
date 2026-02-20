@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<div class="row">
    {{-- Main Settings --}}
    <div class="col-lg-8">
        <form action="{{ route('ai-chatbot.settings.save') }}" method="POST" id="settings-form">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-settings me-2"></i>Cài đặt AI Chatbot
                    </h3>
                </div>
                <div class="card-body">
                    {{-- Enable/Disable --}}
                    <div class="mb-4">
                        <label class="form-check form-switch form-switch-lg">
                            <input type="checkbox" name="enabled" class="form-check-input" 
                                {{ $settings['enabled'] ? 'checked' : '' }}>
                            <span class="form-check-label fs-4">Bật Chatbot</span>
                        </label>
                        <small class="text-muted d-block mt-1">Hiển thị chatbot ở góc phải dưới website</small>
                    </div>

                    <hr>

                    {{-- LLM Provider --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nhà cung cấp AI</label>
                        <div class="row g-3">
                            {{-- Gemini Card --}}
                            <div class="col-md-6">
                                <label class="form-selectgroup-item flex-fill">
                                    <input type="radio" name="llm_provider" value="gemini" class="form-selectgroup-input provider-radio"
                                        {{ $settings['llm_provider'] === 'gemini' ? 'checked' : '' }}>
                                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                                        <div class="me-3">
                                            <span class="avatar bg-blue-lt">
                                                <i class="ti ti-brand-google"></i>
                                            </span>
                                        </div>
                                        <div class="flex-fill">
                                            <div class="fw-bold">Google Gemini</div>
                                            @if($apiKeys['gemini']['has_key'])
                                            <small class="text-success"><i class="ti ti-check"></i> Đã cấu hình</small>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            </div>
                            {{-- OpenAI Card --}}
                            <div class="col-md-6">
                                <label class="form-selectgroup-item flex-fill">
                                    <input type="radio" name="llm_provider" value="openai" class="form-selectgroup-input provider-radio"
                                        {{ $settings['llm_provider'] === 'openai' ? 'checked' : '' }}>
                                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                                        <div class="me-3">
                                            <span class="avatar bg-dark">
                                                <i class="ti ti-brand-openai"></i>
                                            </span>
                                        </div>
                                        <div class="flex-fill">
                                            <div class="fw-bold">OpenAI GPT</div>
                                            @if($apiKeys['openai']['has_key'])
                                            <small class="text-success"><i class="ti ti-check"></i> Đã cấu hình</small>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Gemini Settings --}}
                    <div class="provider-section" id="gemini-section" style="{{ $settings['llm_provider'] !== 'gemini' ? 'display:none;' : '' }}">
                        <div class="card bg-blue-lt mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <i class="ti ti-brand-google me-2"></i>Cấu hình Google Gemini
                                </h4>
                                
                                {{-- API Key --}}
                                <div class="mb-3">
                                    <label class="form-label">API Key</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-key"></i></span>
                                        <input type="password" name="gemini_api_key" id="gemini_api_key" class="form-control" 
                                            placeholder="{{ $apiKeys['gemini']['has_key'] ? $apiKeys['gemini']['masked'] : 'Nhập Gemini API key...' }}">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword(this)">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="fetchModels('gemini')">
                                            <i class="ti ti-refresh"></i> Lấy Models
                                        </button>
                                    </div>
                                    @if($apiKeys['gemini']['has_key'])
                                    <small class="text-success">
                                        <i class="ti ti-check me-1"></i>Đã lưu: {{ $apiKeys['gemini']['masked'] }}
                                    </small>
                                    @else
                                    <small class="text-warning">
                                        <i class="ti ti-alert-triangle me-1"></i>Chưa có API Key
                                    </small>
                                    @endif
                                </div>

                                {{-- Model Selection --}}
                                <div class="mb-0">
                                    <label class="form-label">Model</label>
                                    <select name="gemini_model" id="gemini_model" class="form-select">
                                        @foreach($apiKeys['gemini']['models'] as $value => $label)
                                        <option value="{{ $value }}" {{ $apiKeys['gemini']['model'] === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted" id="gemini_model_status"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- OpenAI Settings --}}
                    <div class="provider-section" id="openai-section" style="{{ $settings['llm_provider'] !== 'openai' ? 'display:none;' : '' }}">
                        <div class="card bg-dark-lt mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <i class="ti ti-brand-openai me-2"></i>Cấu hình OpenAI
                                </h4>
                                
                                {{-- API Key --}}
                                <div class="mb-3">
                                    <label class="form-label">API Key</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-key"></i></span>
                                        <input type="password" name="openai_api_key" id="openai_api_key" class="form-control" 
                                            placeholder="{{ $apiKeys['openai']['has_key'] ? $apiKeys['openai']['masked'] : 'Nhập OpenAI API key...' }}">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword(this)">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="fetchModels('openai')">
                                            <i class="ti ti-refresh"></i> Lấy Models
                                        </button>
                                    </div>
                                    @if($apiKeys['openai']['has_key'])
                                    <small class="text-success">
                                        <i class="ti ti-check me-1"></i>Đã lưu: {{ $apiKeys['openai']['masked'] }}
                                    </small>
                                    @else
                                    <small class="text-warning">
                                        <i class="ti ti-alert-triangle me-1"></i>Chưa có API Key
                                    </small>
                                    @endif
                                </div>

                                {{-- Model Selection --}}
                                <div class="mb-0">
                                    <label class="form-label">Model</label>
                                    <select name="openai_model" id="openai_model" class="form-select">
                                        @foreach($apiKeys['openai']['models'] as $value => $label)
                                        <option value="{{ $value }}" {{ $apiKeys['openai']['model'] === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted" id="openai_model_status"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Welcome Message --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tin nhắn chào mừng</label>
                        <textarea name="welcome_message" class="form-control" rows="3" required>{{ $settings['welcome_message'] }}</textarea>
                        <small class="text-muted">Tin nhắn hiển thị khi khách hàng mở chatbox</small>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Lưu cài đặt
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Help Sidebar --}}
    <div class="col-lg-4">
        <div class="card bg-azure-lt">
            <div class="card-body">
                <h4 class="card-title mb-3">
                    <i class="ti ti-help-circle me-2"></i>Hướng dẫn lấy API Key
                </h4>
                
                <div class="mb-4">
                    <h5 class="text-azure">Google Gemini</h5>
                    <ol class="ps-3 mb-0">
                        <li class="mb-1">Truy cập <a href="https://makersuite.google.com/app/apikey" target="_blank">Google AI Studio</a></li>
                        <li class="mb-1">Đăng nhập tài khoản Google</li>
                        <li class="mb-1">Click "Create API Key"</li>
                        <li>Copy và paste vào ô API Key</li>
                    </ol>
                </div>

                <div>
                    <h5 class="text-dark">OpenAI GPT</h5>
                    <ol class="ps-3 mb-0">
                        <li class="mb-1">Truy cập <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Platform</a></li>
                        <li class="mb-1">Tạo tài khoản và nạp credit</li>
                        <li class="mb-1">Tạo API Key mới</li>
                        <li>Copy và paste vào ô API Key</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="ti ti-info-circle me-2 text-info"></i>Lưu ý
                </h4>
                <ul class="mb-0 ps-3">
                    <li class="mb-2">Nhấn <strong>"Lấy Models"</strong> để xem danh sách models có sẵn cho API key của bạn</li>
                    <li class="mb-2">Gemini API miễn phí với giới hạn 60 requests/phút</li>
                    <li>OpenAI yêu cầu nạp credit để sử dụng</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(btn) {
    const input = btn.previousElementSibling;
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ti ti-eye-off';
    } else {
        input.type = 'password';
        icon.className = 'ti ti-eye';
    }
}

// Show/hide provider sections based on selection
document.querySelectorAll('.provider-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.provider-section').forEach(section => {
            section.style.display = 'none';
        });
        
        const section = document.getElementById(this.value + '-section');
        if (section) {
            section.style.display = 'block';
        }
    });
});

// Saved models from database
const savedModels = {
    gemini: '{{ $apiKeys['gemini']['model'] ?? '' }}',
    openai: '{{ $apiKeys['openai']['model'] ?? '' }}'
};

// Fetch available models from provider API
function fetchModels(provider) {
    const apiKeyInput = document.getElementById(provider + '_api_key');
    const modelSelect = document.getElementById(provider + '_model');
    const statusEl = document.getElementById(provider + '_model_status');
    
    // Use saved model from database, not from dropdown
    const savedModel = savedModels[provider];
    
    // Get new API key if entered, otherwise send empty (controller will use saved key)
    let apiKey = apiKeyInput.value;
    
    statusEl.innerHTML = '<span class="text-info"><i class="ti ti-loader spin"></i> Đang tải danh sách models...</span>';
    
    fetch('{{ route("ai-chatbot.fetch-models") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            provider: provider,
            api_key: apiKey  // Can be empty, controller will use saved key
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && Object.keys(data.models).length > 0) {
            // Clear and populate select
            modelSelect.innerHTML = '';
            for (const [value, label] of Object.entries(data.models)) {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;
                // Restore saved model from database
                if (value === savedModel) {
                    option.selected = true;
                }
                modelSelect.appendChild(option);
            }
            statusEl.innerHTML = '<span class="text-success"><i class="ti ti-check"></i> Đã tải ' + Object.keys(data.models).length + ' models có sẵn</span>';
        } else {
            statusEl.innerHTML = '<span class="text-danger"><i class="ti ti-x"></i> ' + (data.message || 'Không tìm thấy models') + '</span>';
        }
    })
    .catch(error => {
        statusEl.innerHTML = '<span class="text-danger"><i class="ti ti-x"></i> Lỗi kết nối: ' + error.message + '</span>';
    });
}

// Auto-fetch models on page load for providers with saved API keys
document.addEventListener('DOMContentLoaded', function() {
    @if($apiKeys['gemini']['has_key'])
    fetchModels('gemini');
    @endif
    
    @if($apiKeys['openai']['has_key'])
    fetchModels('openai');
    @endif
});
</script>

<style>
.spin {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection
