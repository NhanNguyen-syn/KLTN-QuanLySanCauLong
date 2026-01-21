<?php

use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\CourtBooking\Models\Court;
use Botble\Media\Facades\RvMedia;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Arr;

if (! function_exists('qlscl_parse_shortcode_ids')) {

    function qlscl_parse_shortcode_ids($value): array
    {
        if (is_array($value)) {
            $ids = $value;
        } elseif (is_string($value)) {
            $value = trim($value);

            if ($value === '') {
                $ids = [];
            } elseif (str_starts_with($value, '[')) {
                $decoded = json_decode($value, true);
                $ids = is_array($decoded) ? $decoded : [];
            } else {
                $ids = explode(',', $value);
            }
        } else {
            $ids = [];
        }

        // normalize
        $ids = array_values(array_filter(array_map('intval', $ids)));
        // unique keep order
        $seen = [];
        $unique = [];
        foreach ($ids as $id) {
            if ($id > 0 && ! isset($seen[$id])) {
                $seen[$id] = true;
                $unique[] = $id;
            }
        }

        return $unique;
    }
}
add_action('init', function () {
    Shortcode::register('booking-badminton-court', __('Booking Badminton Court'), __('Booking badminton court grid'), function (ShortcodeCompiler $shortcode) {
        // court_ids có thể được lưu dưới dạng: array | "4,5,6" | "[4,5,6]"
        $selectedCourtIds = qlscl_parse_shortcode_ids($shortcode->court_ids ?? []);

        // Nếu không chọn sân nào => không hiển thị gì (admin phải chủ động chọn)
        if (empty($selectedCourtIds)) {
            return Theme::partial('shortcodes.booking-badminton-court', [
                'shortcode' => $shortcode,
                'props' => [
                    'title' => $shortcode->title,
                    'description' => $shortcode->description,
                    'titleColor' => $shortcode->title_color,
                    'descriptionColor' => $shortcode->description_color,
                    'items' => [],
                    'viewAllText' => $shortcode->view_all_text,
                    'viewAllUrl' => $shortcode->view_all_url,
                    'viewAllBg' => $shortcode->view_all_bg,
                    'viewAllColor' => $shortcode->view_all_color,
                ],
            ]);
        }

        // Kiểm tra xem bảng court_slots có tồn tại không
        $hasSlotsTable = \Illuminate\Support\Facades\Schema::hasTable('court_slots');
        
        $courtsQuery = Court::query()
            ->whereIn('id', $selectedCourtIds)
            ->where('status', 'published');
            
        // Chỉ eager load slots nếu bảng tồn tại
        if ($hasSlotsTable) {
            $courtsQuery->with(['slots' => function ($query) {
                $query->where('status', 'available')
                    ->whereDate('start_at', today())
                    ->orderBy('start_at')
                    ->limit(2);
            }]);
        }
        
        $courts = $courtsQuery->get();

        $items = [];
        $seen = [];
        foreach ($selectedCourtIds as $courtId) {
            $courtId = (int) $courtId;
            if ($courtId <= 0 || isset($seen[$courtId])) {
                continue;
            }
            $seen[$courtId] = true;

            $court = $courts->firstWhere('id', $courtId);
            if (! $court) {
                continue;
            }

            // Get time slots từ field time_display (admin nhập) thay vì từ database
            $timeSlot1 = '';
            $timeSlot2 = '';
            
            if (!empty($court->time_display)) {
                // Parse time_display: "08:00-09:00, 12:00-13:00"
                $timeSlots = array_map('trim', explode(',', $court->time_display));
                $timeSlot1 = $timeSlots[0] ?? '';
                $timeSlot2 = $timeSlots[1] ?? '';
            }

            // Format price - chỉ hiển thị giá bắt đầu từ
            $defaultPrice = $court->default_price ?? 150000;
            $priceLabel = 'Giá bắt đầu từ';
            $priceValue = number_format($defaultPrice) . 'đ/giờ';

            // Get booking URL
            $bookingUrl = $court->booking_url ?? '/dat-san';

            $items[] = [
                'court_id' => $court->id,
                'title' => $court->name,
                'description' => $court->address ?: $court->location ?: '',
                'time_1' => $timeSlot1,
                'time_2' => $timeSlot2,
                'bg_color' => '',
                'text_color' => '',
                'image' => $court->image ? RvMedia::getImageUrl($court->image) : '',
                'price_label' => $priceLabel,
                'price_value' => $priceValue,
                'price_label_color' => '#6b7280',
                'price_value_color' => '#111827',
                'button_url' => $bookingUrl,
                'button_bg_color' => 'rgba(5, 150, 105, 0.1)',
                'button_text_color' => '#059669',
            ];
        }

        $props = [
            'title' => $shortcode->title,
            'description' => $shortcode->description,
            'titleColor' => $shortcode->title_color,
            'descriptionColor' => $shortcode->description_color,
            'items' => $items,
            'viewAllText' => $shortcode->view_all_text,
            'viewAllUrl' => $shortcode->view_all_url,
            'viewAllBg' => $shortcode->view_all_bg,
            'viewAllColor' => $shortcode->view_all_color,
        ];

        return Theme::partial('shortcodes.booking-badminton-court', compact('shortcode', 'props'));
    });

    Shortcode::setAdminConfig('booking-badminton-court', function (array $attributes) {

        $courtOptions = Court::query()
            ->where('status', 'published')
            ->orderByRaw('COALESCE(`order`, 0) ASC')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->all();

        $attributes['court_ids'] = qlscl_parse_shortcode_ids($attributes['court_ids'] ?? []);

        return ShortcodeForm::createFromArray($attributes)
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Tiêu đề'))->toArray())
            ->add('title_color', ColorField::class, ['label' => __('Màu tiêu đề')])
            ->add('description', TextField::class, TextFieldOption::make()->label(__('Mô tả'))->toArray())
            ->add('description_color', ColorField::class, ['label' => __('Màu mô tả')])
            ->add(
                'court_ids',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Sân hiển thị'))
                    ->choices($courtOptions)
                    ->multiple()
                    ->searchable()
                    ->toArray()
            )
            ->add('view_all_text', TextField::class, TextFieldOption::make()->label(__('Chữ nút dưới cùng'))->toArray())
            ->add('view_all_url', TextField::class, TextFieldOption::make()->label(__('Link nút dưới cùng'))->toArray())
            ->add('view_all_bg', ColorField::class, ['label' => __('Màu nền nút dưới cùng')])
            ->add('view_all_color', ColorField::class, ['label' => __('Màu chữ nút dưới cùng')]);
    });
});

