<?php

use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Botble\Slug\Facades\SlugHelper;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\Page\Models\Page;
use Botble\Base\Enums\BaseStatusEnum;

use Illuminate\Support\Facades\Schema;

// Custom routes
Theme::registerRoutes(function (): void {
    // Trang đặt sân cho khách hàng
    Route::get('dat-san', function () {
        // Lấy danh sách sân đã publish để đổ sẵn ra trang (fallback nếu API lỗi)
        $query = \Botble\CourtBooking\Models\Court::query()->with('type');

        // Một số môi trường chưa có cột status/order do chưa chạy migration đầy đủ
        if (Schema::hasColumn('courts', 'status')) {
            $query->where('status', 'published');
        }
        if (Schema::hasColumn('courts', 'order')) {
            $query->orderBy('order', 'asc');
        }

        $courts = $query->get()->map(function ($court) {
            return [
                'id' => (string) $court->getKey(),
                'name' => $court->name,
                'price' => 150000,
                'memberPrice' => 120000,
                'type' => optional($court->type)->name ?? 'Sân tiêu chuẩn',
                'icon' => '🏸',
                'features' => [],
                'capacity' => 4,
                'status' => $court->status ?? 'published',
            ];
        });

        // Chỉ nạp bundle booking cho trang này
        Theme::asset()->container('footer')->usePath()->add('booking-script', 'js/booking.js');

        return Theme::scope('booking', compact('courts'))->render();
    })->name('public.booking');


    // Trang thanh toán (bước 3)
    Route::get('thanh-toan', function () {
        Theme::asset()->container('footer')->usePath()->add('checkout-script', 'js/checkout.js');

        // Resolve the page by slug using SlugHelper to ensure compatibility with Botble's slug system
        $page = null;
        try {
            $slug = SlugHelper::getSlug('thanh-toan', SlugHelper::getPrefix(\Botble\Page\Models\Page::class), \Botble\Page\Models\Page::class);
            if ($slug && $slug->reference_id) {
                $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
            }
        } catch (\Throwable $e) {}

        // Always render checkout view, pass $page so it can show Page Header + content (shortcodes) if available
        return Theme::scope('checkout', compact('page'))->render();
    })->name('public.checkout');


    // Trang xác nhận (bước cuối)
    Route::get('xac-nhan', function () {
        // Resolve the page by slug (nếu có trang CMS với slug xac-nhan thì inject content)
        $page = null;
        try {
            $slug = SlugHelper::getSlug('xac-nhan', SlugHelper::getPrefix(\Botble\Page\Models\Page::class), \Botble\Page\Models\Page::class);
            if ($slug && $slug->reference_id) {
                $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
            }
        } catch (\Throwable $e) {}

        return Theme::scope('confirmation', compact('page'))->render();
    })->name('public.confirmation');

// Trang tra-cuu (UI giống folder d) - tra cứu theo mã hóa đơn (order_code)
    Route::get('tra-cuu', function () {
        Theme::asset()->container('footer')->usePath()->add('lookup-script', 'js/lookup.js');

        return Theme::scope('lookup')->render();
    })->name('public.lookup');

});

Theme::routes();
