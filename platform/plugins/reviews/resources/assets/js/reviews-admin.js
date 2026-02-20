$(document).ready(function () {
    $(document).on('click', '.btn-analyze-review', function (event) {
        event.preventDefault();
        let $button = $(this);
        let url = $button.data('url');

        $button.prop('disabled', true).html('<i class="ti ti-loader animate-spin"></i> Đang phân tích...');

        $.ajax({
            url: url,
            type: 'POST',
            success: function (res) {
                $button.prop('disabled', false).html('<i class="ti ti-brain"></i> Phân tích AI');

                if (res.success) {
                    $('#ai-analysis-content').html(res.data);
                    $('#ai-analysis-modal').modal('show');
                } else {
                    Botble.showError(res.message);
                }
            },
            error: function (res) {
                $button.prop('disabled', false).html('<i class="ti ti-brain"></i> Phân tích AI');
                Botble.handleError(res);
            }
        });
    });
});
