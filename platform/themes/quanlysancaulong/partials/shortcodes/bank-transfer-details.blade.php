@php
    $title = $shortcode->title ?: 'Chi Tiết Chuyển Khoản';
    $bankLabel = $shortcode->bank_label ?: 'Ngân hàng';
    $bankName = $shortcode->bank_name ?: 'Vietcombank (VCB)';
    $accountLabel = $shortcode->account_label ?: 'Số tài khoản';
    $accountNumber = $shortcode->account_number ?: '0123456789';
    $accountNameLabel = $shortcode->account_name_label ?: 'Chủ tài khoản';
    $accountName = $shortcode->account_name ?: 'BADMINTON COURT CENTER';
    $noteLabel = $shortcode->transfer_note_label ?: 'Nội dung chuyển khoản';
    $noteTemplate = $shortcode->transfer_note ?: '[TEN BAN] - DAT SAN';
@endphp

<div id="bank-detail-card" class="card">
    <h3>{{ $title }}</h3>
    <div class="card" style="background:linear-gradient(135deg, #f0fdfa, #f0fdfa); border-color:#a7f3d0; padding: 24px;">
        <div style="margin-bottom: 16px;">
            <div class="field-title">{{ $bankLabel }}</div>
            <strong style="font-size: 1.125rem;">{{ $bankName }}</strong>
        </div>
        <div style="margin-bottom: 16px;">
            <div class="field-title">{{ $accountLabel }}</div>
            <strong style="font-size: 1.25rem; font-family: ui-monospace, monospace; color: #047857;">{{ $accountNumber }}</strong>
        </div>
        <div style="margin-bottom: 16px;">
            <div class="field-title">{{ $accountNameLabel }}</div>
            <strong style="font-size: 1.125rem;">{{ $accountName }}</strong>
        </div>
        <div>
            <div class="field-title">{{ $noteLabel }}</div>
            <div style="font-family:ui-monospace,monospace;font-weight:800;background:#fff;padding:12px;border-radius:8px; border: 1px solid #a7f3d0; margin-top: 4px;" id="transfer-note">{{ $noteTemplate }}</div>
        </div>
    </div>
</div>
