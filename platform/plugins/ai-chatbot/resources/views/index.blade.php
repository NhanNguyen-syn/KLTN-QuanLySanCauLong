@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row">
        {{-- Header Stats --}}
        <div class="col-12 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar avatar-lg bg-white-lt">
                                <i class="ti ti-robot" style="font-size: 2rem;"></i>
                            </span>
                        </div>
                        <div class="col">
                            <h2 class="mb-0 text-white">Trợ lý AI</h2>
                            <p class="mb-0 opacity-75">Quản lý chatbot hỗ trợ khách hàng tự động</p>
                        </div>
                        <div class="col-auto">
                            @if($hasApiKey)
                                <span class="badge bg-success-lt text-success fs-5">
                                    <i class="ti ti-check me-1"></i>Đã kết nối AI
                                </span>
                            @else
                                <span class="badge bg-warning-lt text-warning fs-5">
                                    <i class="ti ti-alert-triangle me-1"></i>Chế độ Mock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-blue-lt me-3">
                            <i class="ti ti-message-2"></i>
                        </span>
                        <div>
                            <div class="text-muted small">Hôm nay</div>
                            <div class="h2 mb-0">{{ $stats['today_conversations'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-green-lt me-3">
                            <i class="ti ti-messages"></i>
                        </span>
                        <div>
                            <div class="text-muted small">Tổng hội thoại</div>
                            <div class="h2 mb-0">{{ $stats['total_conversations'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-purple-lt me-3">
                            <i class="ti ti-database"></i>
                        </span>
                        <div>
                            <div class="text-muted small">Kho tri thức</div>
                            <div class="h2 mb-0">{{ $stats['knowledge_items'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-bolt me-2 text-warning"></i>Thao tác nhanh
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('ai-chatbot.knowledge') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="ti ti-database d-block mb-2" style="font-size: 1.5rem;"></i>
                                Kho tri thức
                            </a>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('ai-chatbot.sync') }}" method="POST" class="h-100">
                                @csrf
                                <button type="submit" class="btn btn-outline-success w-100 h-100 py-3">
                                    <i class="ti ti-refresh d-block mb-2" style="font-size: 1.5rem;"></i>
                                    Sync dữ liệu sân
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('ai-chatbot.conversations') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="ti ti-messages d-block mb-2" style="font-size: 1.5rem;"></i>
                                Lịch sử chat
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('ai-chatbot.settings') }}" class="btn btn-outline-secondary w-100 py-3">
                                <i class="ti ti-settings d-block mb-2" style="font-size: 1.5rem;"></i>
                                Cài đặt
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instructions --}}
        @if(!$hasApiKey)
            <div class="col-12 mt-2">
                <div class="alert alert-warning">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="ti ti-bulb" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h4 class="alert-title">Kích hoạt AI thông minh</h4>
                            <p class="mb-2">Hiện tại chatbot đang sử dụng các câu trả lời mẫu. Để AI trả lời thông minh hơn:</p>
                            <ol class="mb-0">
                                <li>Vào <a href="https://makersuite.google.com/app/apikey" target="_blank">Google AI Studio</a>
                                    để lấy API Key miễn phí</li>
                                <li>Vào <a href="{{ route('ai-chatbot.settings') }}">Cài đặt</a> và nhập API Key</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-info-circle me-2 text-info"></i>Hướng dẫn sử dụng
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="d-flex">
                                <span class="avatar bg-blue-lt me-3">1</span>
                                <div>
                                    <h4 class="mb-1">Thêm Tri thức</h4>
                                    <p class="text-muted mb-0">Thêm thông tin về sân, giá, ưu đãi để AI trả lời chính xác
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex">
                                <span class="avatar bg-green-lt me-3">2</span>
                                <div>
                                    <h4 class="mb-1">Sync dữ liệu</h4>
                                    <p class="text-muted mb-0">Tự động lấy thông tin sân và khung giờ từ database</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex">
                                <span class="avatar bg-purple-lt me-3">3</span>
                                <div>
                                    <h4 class="mb-1">Theo dõi</h4>
                                    <p class="text-muted mb-0">Xem lịch sử chat để cải thiện câu trả lời</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection