<?php

use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register(
    'bank-transfer-details',
    __('Bank Transfer Details'),
    __('Bank transfer info card'),
    function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.bank-transfer-details', compact('shortcode'));
    }
);

Shortcode::setAdminConfig('bank-transfer-details', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->add('title', TextField::class, TextFieldOption::make()->label(__('Title'))->defaultValue('Chi Tiết Chuyển Khoản')->toArray())
        ->add('bank_label', TextField::class, TextFieldOption::make()->label(__('Bank label'))->defaultValue('Ngân hàng')->toArray())
        ->add('bank_name', TextField::class, TextFieldOption::make()->label(__('Bank name'))->defaultValue('Vietcombank (VCB)')->toArray())
        ->add('account_label', TextField::class, TextFieldOption::make()->label(__('Account number label'))->defaultValue('Số tài khoản')->toArray())
        ->add('account_number', TextField::class, TextFieldOption::make()->label(__('Account number'))->defaultValue('0123456789')->toArray())
        ->add('account_name_label', TextField::class, TextFieldOption::make()->label(__('Account holder label'))->defaultValue('Chủ tài khoản')->toArray())
        ->add('account_name', TextField::class, TextFieldOption::make()->label(__('Account holder'))->defaultValue('BADMINTON COURT CENTER')->toArray())
        ->add('transfer_note_label', TextField::class, TextFieldOption::make()->label(__('Transfer note label'))->defaultValue('Nội dung chuyển khoản')->toArray())
        ->add('transfer_note', TextField::class, TextFieldOption::make()->label(__('Transfer note'))->defaultValue('[TEN BAN] - DAT SAN')->toArray());
});
