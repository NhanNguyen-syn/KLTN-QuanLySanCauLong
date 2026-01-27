<?php

use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\ProductsServices\Models\Service;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

// ============================================================================
// REGISTER SHORTCODE
// ============================================================================

Shortcode::register('services-grid', __('Services Grid'), __('Hiển thị lưới dịch vụ đi kèm'), function (ShortcodeCompiler $shortcode) {
    // Get selected service IDs
    $selectedServiceIds = array_filter(explode(',', $shortcode->service_ids ?? ''));

    if (empty($selectedServiceIds)) {
        $services = collect();
    } else {
        $services = Service::query()
            ->where('status', 'published')
            ->whereIn('id', $selectedServiceIds)
            ->orderBy('order')
            ->get();
    }

    return Theme::partial('shortcodes.services-grid', compact('shortcode', 'services'));
});

// ============================================================================
// ADMIN CONFIG
// ============================================================================

Shortcode::setAdminConfig('services-grid', function (array $attributes) {
    // Get all services for selection
    $serviceOptions = Service::query()
        ->where('status', 'published')
        ->orderBy('order')
        ->pluck('name', 'id')
        ->toArray();

    // Pre-process attributes for multi-select fields
    if (isset($attributes['service_ids']) && is_string($attributes['service_ids'])) {
        $attributes['service_ids'] = array_filter(explode(',', $attributes['service_ids']));
    }

    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Title'))
                ->placeholder(__('Dịch Vụ Thêm'))
                ->defaultValue('Dịch Vụ Thêm')
                ->toArray()
        )
        ->add(
            'service_ids',
            SelectField::class,
            SelectFieldOption::make()
                ->label(__('Chọn dịch vụ hiển thị'))
                ->choices($serviceOptions)
                ->searchable()
                ->multiple()
                ->helperText(__('Vui lòng chọn ít nhất một dịch vụ để hiển thị'))
                ->toArray()
        );
});
