<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;

use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Media\Facades\RvMedia;
use Botble\Reviews\Models\Review;

Shortcode::register('testimonials', __('Testimonials'), __('Testimonials'), function (ShortcodeCompiler $shortcode) {
    $testimonials = [];

    // Get selected review IDs from admin config
    $selectedIds = array_filter(explode(',', $shortcode->review_ids ?? ''));

    if (!empty($selectedIds)) {
        $reviews = Review::query()
            ->with('member')
            ->whereIn('id', $selectedIds)
            ->where('is_approved', true)
            ->get();

        foreach ($reviews as $review) {
            $avatar = '';
            if ($review->member_id && $review->member) {
                $avatar = $review->member->avatar_url;
            }

            $testimonials[] = [
                'name' => $review->name ?? 'Khách hàng',
                'role' => '',
                'avatar' => $avatar,
                'content' => $review->comment ?? '',
                'stars' => (int)($review->rating ?? 5),
            ];
        }
    }

    return Theme::partial('shortcodes.testimonials', compact('shortcode', 'testimonials'));
});

Shortcode::setAdminConfig('testimonials', function (array $attributes) {
    // Get all approved reviews for selection
    $reviewOptions = Review::query()
        ->where('is_approved', true)
        ->latest()
        ->get()
        ->mapWithKeys(function ($review) {
            $label = $review->name . ' - ' . $review->rating . '⭐ - ' . mb_substr($review->comment, 0, 50) . '...';
            return [$review->id => $label];
        })
        ->toArray();

    // Pre-process attributes for multi-select fields
    if (isset($attributes['review_ids']) && is_string($attributes['review_ids'])) {
        $attributes['review_ids'] = array_filter(explode(',', $attributes['review_ids']));
    }

    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
                ->defaultValue('What our members say')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Subtitle'))
                ->rows(2)
                ->defaultValue('Our students love the coaching, fun training sessions, and the chance to improve their skills while enjoying every moment on the court.')
                ->toArray()
        )
        ->add(
            'title_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Title Color'))->defaultValue('#153E35')->toArray()
        )
        ->add(
            'subtitle_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Subtitle Color'))->defaultValue('#6b7280')->toArray()
        )
        ->add(
            'bg_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Background Color'))->defaultValue('#F3F7F5')->toArray()
        )
        ->add(
            'card_bg_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Card Background Color'))->defaultValue('#ffffff')->toArray()
        )
        ->add(
            'star_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Star Color'))->defaultValue('#C6F432')->toArray()
        )
        ->add(
            'speed',
            NumberField::class,
            InputFieldOption::make()->label(__('Row 1 speed (ms)'))->placeholder(5000)->toArray()
        )
        ->add(
            'second_row_speed',
            NumberField::class,
            InputFieldOption::make()->label(__('Row 2 speed (ms)'))->placeholder(7000)->toArray()
        )
        ->add(
            'button_text',
            TextField::class,
            TextFieldOption::make()->label(__('Button Text'))->defaultValue('See more')->toArray()
        )
        ->add(
            'button_url',
            TextField::class,
            TextFieldOption::make()->label(__('Button URL'))->defaultValue('#')->toArray()
        )
        ->add(
            'button_bg_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Button Background Color'))->defaultValue('#C6F432')->toArray()
        )
        ->add(
            'button_text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Button Text Color'))->defaultValue('#153E35')->toArray()
        )
        ->add(
            'review_ids',
            SelectField::class,
            SelectFieldOption::make()
                ->label(__('Chọn bài đánh giá hiển thị (tối đa 20)'))
                ->choices($reviewOptions)
                ->searchable()
                ->multiple()
                ->helperText(__('Chọn các bài đánh giá đã duyệt để hiển thị trong phần Testimonials'))
                ->toArray()
        );
});
