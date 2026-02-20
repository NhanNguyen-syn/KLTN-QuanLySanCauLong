@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title mb-0">Kho tri thức</h3>
            <p class="text-muted mb-0 mt-1">Quản lý thông tin để AI trả lời khách hàng</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('ai-chatbot.sync') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-success">
                    <i class="ti ti-refresh me-1"></i> Sync từ Database
                </button>
            </form>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKnowledgeModal">
                <i class="ti ti-plus me-1"></i> Thêm mới
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($items->isEmpty())
        <div class="empty py-5">
            <div class="empty-icon">
                <i class="ti ti-database-off" style="font-size: 3rem; color: #6c757d;"></i>
            </div>
            <p class="empty-title h4 mt-3">Chưa có dữ liệu tri thức</p>
            <p class="empty-subtitle text-muted">
                Thêm các thông tin về sân, giá, ưu đãi để AI có thể trả lời chính xác.
            </p>
            <div class="empty-action mt-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKnowledgeModal">
                    <i class="ti ti-plus me-1"></i> Thêm tri thức đầu tiên
                </button>
            </div>
        </div>
        @else
        {{-- Category Filter --}}
        <div class="mb-4">
            <div class="btn-group" role="group">
                <a href="{{ route('ai-chatbot.knowledge') }}" class="btn btn-outline-secondary {{ !request('category') ? 'active' : '' }}">
                    Tất cả ({{ $items->count() }})
                </a>
                @php
                    $categories = [
                        'court' => ['name' => 'Sân', 'color' => 'primary', 'icon' => 'building'],
                        'pricing' => ['name' => 'Giá cả', 'color' => 'success', 'icon' => 'currency-dong'],
                        'promotion' => ['name' => 'Khuyến mãi', 'color' => 'warning', 'icon' => 'discount-2'],
                        'faq' => ['name' => 'FAQ', 'color' => 'info', 'icon' => 'help'],
                        'general' => ['name' => 'Chung', 'color' => 'secondary', 'icon' => 'info-circle'],
                    ];
                @endphp
                @foreach($categories as $key => $cat)
                    @php $count = $items->where('category', $key)->count(); @endphp
                    @if($count > 0)
                    <a href="{{ route('ai-chatbot.knowledge', ['category' => $key]) }}" 
                       class="btn btn-outline-{{ $cat['color'] }} {{ request('category') === $key ? 'active' : '' }}">
                        <i class="ti ti-{{ $cat['icon'] }} me-1"></i>{{ $cat['name'] }} ({{ $count }})
                    </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Knowledge Items Grid --}}
        <div class="row g-3">
            @foreach($items as $item)
            @php 
                $cat = $categories[$item->category] ?? $categories['general'];
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-{{ $cat['color'] }} border-start border-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-{{ $cat['color'] }}-lt text-{{ $cat['color'] }}">
                                <i class="ti ti-{{ $cat['icon'] }} me-1"></i>{{ $cat['name'] }}
                            </span>
                            <div class="dropdown">
                                <button class="btn btn-ghost-secondary btn-sm" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        <i class="ti ti-edit me-2"></i>Chỉnh sửa
                                    </button>
                                    <form action="{{ route('ai-chatbot.knowledge.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Xóa item này?')">
                                            <i class="ti ti-trash me-2"></i>Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title mb-2">{{ $item->title }}</h4>
                        <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.5;">
                            {{ Str::limit($item->content, 150) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 pt-0">
                        <small class="text-muted">
                            <i class="ti ti-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('ai-chatbot.knowledge.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Chỉnh sửa: {{ $item->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label required">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Danh mục</label>
                                    <select name="category" class="form-select" required>
                                        @foreach($categories as $key => $cat)
                                        <option value="{{ $key }}" {{ $item->category === $key ? 'selected' : '' }}>
                                            {{ $cat['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Nội dung</label>
                                    <textarea name="content" class="form-control" rows="6" required>{{ $item->content }}</textarea>
                                    <small class="text-muted">Viết rõ ràng, ngắn gọn để AI hiểu và trả lời chính xác.</small>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" {{ $item->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">Kích hoạt</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addKnowledgeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('ai-chatbot.knowledge.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="ti ti-plus me-2"></i>Thêm tri thức mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-4">
                        <i class="ti ti-info-circle me-2"></i>
                        Thêm thông tin để AI có thể trả lời khách hàng chính xác hơn.
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" required 
                            placeholder="VD: Giờ hoạt động của sân">
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Danh mục</label>
                        <div class="row g-2">
                            @foreach($categories ?? [] as $key => $cat)
                            <div class="col-auto">
                                <input type="radio" class="btn-check" name="category" id="cat_{{ $key }}" value="{{ $key }}" {{ $key === 'faq' ? 'checked' : '' }}>
                                <label class="btn btn-outline-{{ $cat['color'] }}" for="cat_{{ $key }}">
                                    <i class="ti ti-{{ $cat['icon'] }} me-1"></i>{{ $cat['name'] }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nội dung</label>
                        <textarea name="content" class="form-control" rows="6" required 
                            placeholder="Nhập nội dung chi tiết để AI học. VD: Sân hoạt động từ 6h đến 22h hàng ngày..."></textarea>
                        <small class="text-muted">Viết rõ ràng, ngắn gọn. AI sẽ sử dụng thông tin này để trả lời khách hàng.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Thêm tri thức
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection