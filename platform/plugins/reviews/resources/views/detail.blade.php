@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<div class="row">
    {{-- Review Detail Card --}}
    <div class="col-md-7">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="ti ti-message-circle"></i> Chi tiết đánh giá #{{ $review->id }}
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-muted" style="width: 180px;">Người đánh giá</td>
                            <td>
                                <i class="ti ti-user"></i>
                                {{ $review->member ? $review->member->name : $review->name }}
                                @if(!$review->member_id)
                                    <span class="badge bg-secondary ms-1">Khách</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Đánh giá</td>
                            <td>
                                <span class="text-warning fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <span class="ms-2 badge {{ $review->rating >= 4 ? 'bg-success' : ($review->rating >= 3 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $review->rating }}/5
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Nội dung</td>
                            <td>
                                <div class="p-3 bg-light rounded border" style="white-space: pre-wrap;">{{ $review->comment ?: '(Không có nội dung)' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Trạng thái</td>
                            <td>
                                @if($review->is_approved)
                                    <span class="badge bg-success"><i class="ti ti-check"></i> Đã duyệt</span>
                                @else
                                    <span class="badge bg-warning"><i class="ti ti-clock"></i> Chờ duyệt</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Ngày tạo</td>
                            <td>
                                <i class="ti ti-calendar"></i>
                                {{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : '—' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Hữu ích</td>
                            <td>
                                <i class="ti ti-thumb-up"></i> {{ $review->helpful ?? 0 }} lượt
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Images Section --}}
                @php
                    $images = $review->images;
                @endphp
                @if(!empty($images) && is_array($images))
                    <div class="mt-3">
                        <h5 class="fw-bold text-muted mb-2"><i class="ti ti-photo"></i> Hình ảnh đính kèm</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($images as $image)
                                @if(!empty($image))
                                    <a href="{{ RvMedia::getImageUrl($image) }}" target="_blank" class="d-block">
                                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="Review image"
                                             style="max-width: 150px; max-height: 150px; border-radius: 8px; object-fit: cover; border: 2px solid #e9ecef; transition: transform 0.2s;"
                                             onmouseover="this.style.transform='scale(1.05)'"
                                             onmouseout="this.style.transform='scale(1)'">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Replies Section --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="ti ti-messages"></i> Phản hồi ({{ count($replies) }})
                </h4>
            </div>
            <div class="card-body">
                @if(count($replies) > 0)
                    @foreach($replies as $reply)
                        <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center {{ $reply->member_id ? 'bg-primary' : 'bg-success' }}" style="width:40px;height:40px;">
                                    <i class="ti {{ $reply->member_id ? 'ti-user' : 'ti-shield-check' }} text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <strong>{{ $reply->replier_name }}</strong>
                                    @if(!$reply->member_id)
                                        <span class="badge bg-success"><i class="ti ti-shield-check"></i> Admin</span>
                                    @else
                                        <span class="badge bg-secondary">Khách hàng</span>
                                    @endif
                                    <small class="text-muted ms-auto">
                                        <i class="ti ti-clock"></i>
                                        {{ \Carbon\Carbon::parse($reply->created_at)->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $reply->comment }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-reply" data-id="{{ $reply->id }}" title="Xóa phản hồi">
                                    <i class="ti ti-trash"></i> Xóa
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-3">
                        <i class="ti ti-message-off" style="font-size:32px;"></i>
                        <p class="mt-2 mb-0">Chưa có phản hồi nào</p>
                    </div>
                @endif

                {{-- Reply Form --}}
                <div class="mt-3 pt-3 border-top">
                    <h6 class="fw-bold mb-2"><i class="ti ti-pencil"></i> Phản hồi đánh giá</h6>
                    <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <textarea name="comment" class="form-control" rows="3" placeholder="Nhập phản hồi của bạn..." required maxlength="1000"></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Phản hồi sẽ hiển thị với tên "Quản trị viên"</small>
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-send"></i> Gửi phản hồi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    {{-- AI Analysis Panel --}}
    <div class="col-md-5">
        <div class="card mb-4 {{ $review->rating <= 3 ? 'border-warning' : 'border-info' }}">
            <div class="card-header {{ $review->rating <= 3 ? 'bg-warning bg-opacity-10' : 'bg-info bg-opacity-10' }}">
                <h4 class="card-title mb-0">
                    <i class="ti ti-brain"></i> Phân tích AI
                </h4>
            </div>
            <div class="card-body">
                @if($review->rating <= 3)
                    <div class="alert alert-warning d-flex align-items-center mb-3">
                        <i class="ti ti-alert-triangle fs-4 me-2"></i>
                        <div>
                            <strong>Đánh giá tiêu cực!</strong> Bài đánh giá này chỉ có <strong>{{ $review->rating }} sao</strong>. 
                            Nhấn nút bên dưới để AI phân tích và đề xuất giải pháp cho chủ sân.
                        </div>
                    </div>

                    <button type="button" class="btn btn-info w-100 mb-3" id="btn-analyze-ai"
                            data-url="{{ route('reviews.analyze', $review->id) }}">
                        <i class="ti ti-brain"></i> Phân tích bằng AI & Đề xuất giải pháp
                    </button>

                    <div id="ai-analysis-loading" class="text-center d-none py-4">
                        <div class="spinner-border text-info" role="status">
                            <span class="visually-hidden">Đang phân tích...</span>
                        </div>
                        <p class="text-muted mt-2">AI đang phân tích bài đánh giá...</p>
                    </div>

                    <div id="ai-analysis-result" class="d-none">
                        <div class="border rounded p-3 bg-light" id="ai-analysis-content">
                            {{-- AI result will be injected here --}}
                        </div>
                    </div>

                    <div id="ai-analysis-error" class="alert alert-danger d-none mt-3">
                        <i class="ti ti-alert-circle"></i> <span id="ai-error-message"></span>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-mood-happy text-success" style="font-size: 48px;"></i>
                        <p class="text-muted mt-3">Đánh giá tích cực (<strong>{{ $review->rating }} sao</strong>).<br>Không cần phân tích AI.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnAnalyze = document.getElementById('btn-analyze-ai');
        if (!btnAnalyze) return;

        btnAnalyze.addEventListener('click', function() {
            var url = this.getAttribute('data-url');
            var loading = document.getElementById('ai-analysis-loading');
            var result = document.getElementById('ai-analysis-result');
            var content = document.getElementById('ai-analysis-content');
            var errorDiv = document.getElementById('ai-analysis-error');
            var errorMsg = document.getElementById('ai-error-message');

            // Show loading, hide others
            btnAnalyze.disabled = true;
            btnAnalyze.innerHTML = '<i class="ti ti-loader"></i> Đang phân tích...';
            loading.classList.remove('d-none');
            result.classList.add('d-none');
            errorDiv.classList.add('d-none');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                loading.classList.add('d-none');
                btnAnalyze.disabled = false;
                btnAnalyze.innerHTML = '<i class="ti ti-brain"></i> Phân tích lại';

                if (data.success) {
                    content.innerHTML = data.data;
                    result.classList.remove('d-none');
                } else {
                    errorMsg.textContent = data.message || 'Có lỗi xảy ra.';
                    errorDiv.classList.remove('d-none');
                }
            })
            .catch(function(err) {
                loading.classList.add('d-none');
                btnAnalyze.disabled = false;
                btnAnalyze.innerHTML = '<i class="ti ti-brain"></i> Thử lại';
                errorMsg.textContent = 'Lỗi kết nối: ' + err.message;
                errorDiv.classList.remove('d-none');
            });
        });

        // Delete reply buttons
        document.querySelectorAll('.btn-delete-reply').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (!confirm('Bạn có chắc muốn xóa phản hồi này?')) return;
                var id = this.getAttribute('data-id');
                var el = this.closest('.d-flex.gap-3');
                fetch('{{ url("admin/reviews/reply") }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success && el) el.remove();
                });
            });
        });
    });
</script>
@endpush
