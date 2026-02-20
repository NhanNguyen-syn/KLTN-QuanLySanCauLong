<div class="modal fade" id="ai-analysis-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-brain text-info"></i> Phân tích đánh giá & Đề xuất giải pháp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ai-analysis-content" class="p-3 bg-light rounded">
                    <!-- AI Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="navigator.clipboard.writeText($('#ai-analysis-content').text()); Botble.showSuccess('Đã sao chép nội dung!');">Sao chép</button>
            </div>
        </div>
    </div>
</div>
