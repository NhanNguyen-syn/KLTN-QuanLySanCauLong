@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title mb-0">Lịch sử hội thoại</h3>
            <p class="text-muted mb-0 mt-1">Xem các cuộc chat giữa khách hàng và AI</p>
        </div>
        <span class="badge bg-primary fs-6">{{ $conversations->total() }} cuộc hội thoại</span>
    </div>
    <div class="card-body p-0">
        @if($conversations->isEmpty())
            <div class="empty py-5">
                <div class="empty-icon">
                    <i class="ti ti-messages-off" style="font-size: 3rem; color: #6c757d;"></i>
                </div>
                <p class="empty-title h4 mt-3">Chưa có hội thoại nào</p>
                <p class="empty-subtitle text-muted">
                    Khi khách hàng chat với AI, các hội thoại sẽ hiển thị tại đây.
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Session</th>
                            <th>Khách hàng</th>
                            <th class="text-center">Số tin nhắn</th>
                            <th>Lần cuối</th>
                            <th style="width: 100px;">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conversations as $conv)
                        @php 
                            $messages = json_decode($conv->messages ?? '[]', true) ?: [];
                            $msgCount = count($messages);
                            $lastUserMsg = collect($messages)->where('role', 'user')->last()['content'] ?? '';
                        @endphp
                        <tr>
                            <td>
                                <code class="text-muted">{{ Str::limit($conv->session_id, 25) }}</code>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm bg-{{ $conv->first_name ? 'blue' : 'secondary' }}-lt me-2">
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <div>
                                        <div class="fw-medium">{{ $conv->first_name ? $conv->first_name . ' ' . $conv->last_name : 'Khách' }}</div>
                                        @if($lastUserMsg)
                                            <div class="text-muted small">{{ Str::limit($lastUserMsg, 40) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary-lt">{{ $msgCount }} tin</span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="ti ti-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($conv->updated_at)->diffForHumans() }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-ghost-primary" data-bs-toggle="modal" data-bs-target="#chatModal{{ $conv->id }}">
                                    <i class="ti ti-eye"></i> Xem
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="card-footer d-flex justify-content-end">
                {{ $conversations->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Chat Detail Modals (outside table for proper rendering) --}}
@foreach($conversations as $conv)
@php 
    $messages = json_decode($conv->messages ?? '[]', true) ?: [];
@endphp
<div class="modal fade" id="chatModal{{ $conv->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="ti ti-messages me-2"></i>
                    Chat với {{ $conv->first_name ? $conv->first_name . ' ' . $conv->last_name : 'Khách' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="chat-messages-container" style="height: 75vh; max-height: 800px; overflow-y: auto;">
                    <div class="chat-messages p-3" style="background: #f8f9fa;">
                        @foreach($messages as $msg)
                        <div class="d-flex mb-3 {{ $msg['role'] === 'user' ? 'justify-content-end' : '' }}">
                            @if($msg['role'] !== 'user')
                                <span class="avatar avatar-sm bg-primary me-2 flex-shrink-0">B</span>
                            @endif
                            <div class="chat-bubble p-3 rounded-3 {{ $msg['role'] === 'user' ? 'bg-primary text-white' : 'bg-white border' }}" 
                                 style="max-width: 70%;">
                                {{ $msg['content'] }}
                                <div class="small {{ $msg['role'] === 'user' ? 'text-white-50' : 'text-muted' }} mt-1">
                                    {{ isset($msg['time']) ? \Carbon\Carbon::parse($msg['time'])->format('H:i d/m') : '' }}
                                </div>
                            </div>
                            @if($msg['role'] === 'user')
                                <span class="avatar avatar-sm bg-secondary ms-2 flex-shrink-0">K</span>
                            @endif
                        </div>
                        @endforeach

                        @if(empty($messages))
                            <div class="text-center text-muted py-4">
                                Không có tin nhắn
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-muted me-auto">
                    <small>Session: {{ $conv->session_id }}</small>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection