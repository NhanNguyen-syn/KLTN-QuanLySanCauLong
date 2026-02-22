<?php

use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Botble\Slug\Facades\SlugHelper;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\Page\Models\Page;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\CourtBooking\Models\BookingList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ReviewController;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Custom routes
Theme::registerRoutes(function (): void {
    // Trang chi tiết sân
    Route::get('san-gia/{slug}', function ($slug) {
        $court = \Botble\CourtBooking\Models\Court::query()
            ->with('type', 'courtStatus')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$court) {
            abort(404);
        }

        return Theme::scope('court-detail', compact('court'))->render();
    })->name('public.court.detail');

    // Trang đặt sân cho khách hàng
    Route::get('dat-san', function () {
        $page = null;
        try {
            $slug = SlugHelper::getSlug('dat-san', SlugHelper::getPrefix(Page::class), Page::class);
            if ($slug && $slug->reference_id) {
                $page = app(PageInterface::class)->getFirstBy([
                    'id' => $slug->reference_id,
                    'status' => BaseStatusEnum::PUBLISHED,
                ]);
            }
        } catch (\Throwable $e) {}
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
        Theme::asset()->container('footer')->usePath()->add('booking-script', 'js/booking.js?v=1.3');

        return Theme::scope('booking', compact('courts', 'page'))->render();
    })->name('public.booking');

// Static content pages cloned from Next.js d/ folder
        Route::get('chinh-sach-huy-doi-hoan', function () {
            $page = null;
            try {
                $slug = SlugHelper::getSlug('chinh-sach-huy-doi-hoan', SlugHelper::getPrefix(Page::class), Page::class);
                if ($slug && $slug->reference_id) {
                    $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
                }
            } catch (\Throwable $e) {}
            return Theme::scope('policy', compact('page'))->render();
        })->name('public.policy');

        Route::get('tieu-chuan-dich-vu', function () {
            $page = null;
            try {
                $slug = SlugHelper::getSlug('tieu-chuan-dich-vu', SlugHelper::getPrefix(Page::class), Page::class);
                if ($slug && $slug->reference_id) {
                    $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
                }
            } catch (\Throwable $e) {}
            return Theme::scope('service-standard', compact('page'))->render();
        })->name('public.service-standard');

        Route::get('ve-chung-toi', function () {
            $page = null;
            try {
                $slug = SlugHelper::getSlug('ve-chung-toi', SlugHelper::getPrefix(Page::class), Page::class);
                if ($slug && $slug->reference_id) {
                    $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
                }
            } catch (\Throwable $e) {}
            return Theme::scope('about', compact('page'))->render();
        })->name('public.about');

        // Trang đánh giá
        Route::get('danh-gia', function () {
            $page = null;
            try {
                $slug = SlugHelper::getSlug('danh-gia', SlugHelper::getPrefix(Page::class), Page::class);
                if ($slug && $slug->reference_id) {
                    $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
                }
            } catch (\Throwable $e) {}
            return Theme::scope('reviews', compact('page'))->render();
        })->name('public.reviews');

        // Trang sản phẩm & dịch vụ
        Route::get('san-pham-dich-vu', function () {
            $page = null;
            try {
                $slug = SlugHelper::getSlug('san-pham-dich-vu', SlugHelper::getPrefix(Page::class), Page::class);
                if ($slug && $slug->reference_id) {
                    $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
                }
            } catch (\Throwable $e) {}
            return Theme::scope('products', compact('page'))->render();
        })->name('public.products');

    // Trang thanh toán (bước 3)
    Route::get('ajax/cities', function() {
    $cities = \Botble\Location\Models\City::where('status', 'published')->orderBy('name')->get(['id', 'name']);
    return response()->json($cities);
});

// Download Invoice Route
Route::get('invoice/download/{code}', function ($code) {
    if (!$code) abort(404);

    $bookings = \Botble\CourtBooking\Models\BookingList::query()
        ->where('order_code', $code)
        ->get();

    if ($bookings->isEmpty()) abort(404, 'Order not found');

    $service = new \Botble\CourtBooking\Services\InvoicePdfService();
    $pdf = $service->generateGroupedPdf($bookings);
    
    return $pdf->download('hoa-don-' . $code . '.pdf');
});

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


    Route::post('ajax/booking/order-code', function (Request $request) {
        $dateValue = (string) $request->input('date', '');
        if ($dateValue === '') {
            return response()->json(['message' => 'Missing date.'], 422);
        }

        try {
            $date = Carbon::parse($dateValue);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Invalid date.'], 422);
        }

        $orderCode = DB::transaction(function () use ($date) {
            $prefix = 'BD-' . $date->format('Ymd') . '-';
            $latest = BookingList::query()
                ->where('order_code', 'like', $prefix . '%')
                ->lockForUpdate()
                ->orderBy('order_code', 'desc')
                ->value('order_code');

            $nextSeq = 1;
            if ($latest) {
                $lastSeqStr = substr($latest, strrpos($latest, '-') + 1);
                $nextSeq = ((int) $lastSeqStr) + 1;
            }

            return $prefix . str_pad((string) $nextSeq, 3, '0', STR_PAD_LEFT);
        });

        return response()->json(['order_code' => $orderCode]);
    })->name('public.booking.order-code');

    // Review API routes
    Route::get('api/reviews', [\App\Http\Controllers\ReviewController::class, 'index'])
        ->name('api.reviews.index');
    
    Route::post('api/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])
        ->name('api.reviews.store');
    
    Route::post('api/reviews/{id}/helpful', [\App\Http\Controllers\ReviewController::class, 'helpful'])
        ->name('api.reviews.helpful');

    Route::delete('api/reviews/{id}', [\App\Http\Controllers\ReviewController::class, 'destroy'])
        ->name('api.reviews.destroy');

    Route::delete('api/reviews/replies/{id}', [\App\Http\Controllers\ReviewController::class, 'deleteReply'])
        ->name('api.reviews.deleteReply');

Route::post('ajax/vnpay/qr', function (Request $request) {
        $tmnCode = env('vnp_TmnCode', env('VNP_TMN_CODE'));
        $hashSecret = env('vnp_HashSecret', env('VNP_HASH_SECRET'));
        $vnpUrl = env('vnp_Url', env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'));
        $ipnUrl = env('vnp_IpnUrl', env('VNP_IPN_URL', ''));
        $ipnUrl = is_string($ipnUrl) ? trim($ipnUrl) : '';
        $ipAddr = env('vnp_IpAddr', env('VNP_IP_ADDR', $request->ip()));

        if (! $tmnCode || ! $hashSecret) {
            return response()->json([
                'message' => 'VNPAY config missing.',
            ], 422);
        }

        $amount = (int) $request->input('amount', 0);
        if ($amount <= 0) {
            return response()->json([
                'message' => 'Invalid amount.',
            ], 422);
        }

        $orderCode = (string) $request->input('order_code', '');
        $txnRef = $orderCode !== '' ? $orderCode : ('BD' . now()->format('YmdHis') . rand(1000, 9999));
        $orderInfo = (string) ($request->input('order_info') ?: 'Thanh toan dat san');

        $params = [
            'vnp_Version' => '2.1.0',
            'vnp_Command' => 'pay',
            'vnp_TmnCode' => $tmnCode,
            'vnp_Amount' => $amount * 100,
            'vnp_CurrCode' => 'VND',
            'vnp_TxnRef' => $txnRef,
            'vnp_OrderInfo' => $orderInfo,
            'vnp_OrderType' => 'other',
            'vnp_Locale' => 'vn',
            'vnp_ReturnUrl' => url('/xac-nhan'),
            'vnp_IpAddr' => $ipAddr,
            'vnp_CreateDate' => now()->format('YmdHis'),
        ];

        $isLocalIpn = $ipnUrl !== '' && (str_contains($ipnUrl, 'localhost') || str_contains($ipnUrl, '127.0.0.1') || str_contains($ipnUrl, '.test'));
        if ($ipnUrl && ! $isLocalIpn) {
            $params['vnp_IpnUrl'] = $ipnUrl;
        }

        ksort($params);

        $hashDataParts = [];
        $queryParts = [];
        foreach ($params as $key => $value) {
            $hashDataParts[] = urlencode($key) . '=' . urlencode((string) $value);
            $queryParts[] = urlencode($key) . '=' . urlencode((string) $value);
        }

        $hashData = implode('&', $hashDataParts);
        $query = implode('&', $queryParts);
        $secureHash = hash_hmac('sha512', $hashData, $hashSecret);
        $paymentUrl = $vnpUrl . '?' . $query . '&vnp_SecureHash=' . $secureHash;
        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=' . urlencode($paymentUrl);

        return response()->json([
            'payment_url' => $paymentUrl,
            'qr_image_url' => $qrImageUrl,
            'txn_ref' => $txnRef,
        ]);
    })->name('public.vnpay.qr');


    // Trang xac-nhan (buoc cuoi)
    Route::get('xac-nhan', function (Request $request) {
        $hashSecret = env('vnp_HashSecret', env('VNP_HASH_SECRET'));

        $input = $request->all();
        if ($hashSecret && isset($input['vnp_SecureHash'])) {
            $secureHash = $input['vnp_SecureHash'];
            unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);
            ksort($input);
            $hashData = [];
            foreach ($input as $key => $value) {
                $hashData[] = urlencode($key) . '=' . urlencode((string) $value);
            }
            $calcHash = hash_hmac('sha512', implode('&', $hashData), $hashSecret);

            if (hash_equals($calcHash, $secureHash)) {
                $txnRef = $input['vnp_TxnRef'] ?? null;
                $responseCode = $input['vnp_ResponseCode'] ?? null;
                $transactionStatus = $input['vnp_TransactionStatus'] ?? null;
                $isSuccess = $responseCode === '00' && $transactionStatus === '00';

                if (! $isSuccess) {
                    return redirect()->to(url('/dat-san'));
                }

                if ($txnRef) {
                    $bookings = BookingList::query()
                        ->where('order_code', $txnRef)
                        ->get();

                    foreach ($bookings as $booking) {
                        $booking->update([
                            'status' => $isSuccess ? 'paid' : 'failed',
                            'invoice_updated_at' => now(),
                        ]);
                    }

                    if ($isSuccess && $bookings->isNotEmpty()) {
                        // Send ONE email for the whole order (wrap in try-catch so email errors don't crash)
                        try {
                            $email = $bookings->first()->email;
                            \Botble\CourtBooking\Services\InvoicePdfService::sendGroupedEmail($bookings, $email);
                        } catch (\Throwable $emailErr) {
                            \Log::error('[VNPAY EMAIL ERROR]', ['error' => $emailErr->getMessage(), 'order_code' => $txnRef]);
                        }
                    }
                }
            }
        }

        // Resolve the page by slug (neu co trang CMS voi slug xac-nhan thi inject content)
        $page = null;
        try {
            $slug = SlugHelper::getSlug('xac-nhan', SlugHelper::getPrefix(\Botble\Page\Models\Page::class), \Botble\Page\Models\Page::class);
            if ($slug && $slug->reference_id) {
                $page = app(PageInterface::class)->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
            }
        } catch (\Throwable $e) {}

        return Theme::scope('confirmation', compact('page'))->render();
    })->name('public.confirmation');

    Route::match(['GET', 'POST'], 'vnpay/ipn', function (Request $request) {
        $hashSecret = env('vnp_HashSecret', env('VNP_HASH_SECRET'));
        if (! $hashSecret) {
            return response()->json(['RspCode' => '99', 'Message' => 'Config missing']);
        }

        $input = $request->all();
        $secureHash = $input['vnp_SecureHash'] ?? '';
        unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);
        ksort($input);
        $hashData = [];
        foreach ($input as $key => $value) {
            $hashData[] = urlencode($key) . '=' . urlencode((string) $value);
        }
        $calcHash = hash_hmac('sha512', implode('&', $hashData), $hashSecret);

        if (! hash_equals($calcHash, $secureHash)) {
            return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
        }

        $txnRef = $input['vnp_TxnRef'] ?? null;
        $responseCode = $input['vnp_ResponseCode'] ?? null;
        $transactionStatus = $input['vnp_TransactionStatus'] ?? null;
        $isSuccess = $responseCode === '00' && $transactionStatus === '00';

        if ($txnRef) {
            $bookings = BookingList::query()
                ->where('order_code', $txnRef)
                ->get();

            foreach ($bookings as $booking) {
                $booking->update([
                    'status' => $isSuccess ? 'paid' : 'failed',
                    'invoice_updated_at' => now(),
                ]);
            }

            if ($isSuccess && $bookings->isNotEmpty()) {
                $email = $bookings->first()->email;
                \Botble\CourtBooking\Services\InvoicePdfService::sendGroupedEmail($bookings, $email);
            }
        }

        return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
    })->name('public.vnpay.ipn');

    Route::get('tra-cuu', function () {
        Theme::asset()->container('footer')->usePath()->add('lookup-script', 'js/lookup.js');

        return Theme::scope('lookup')->render();
    })->name('public.lookup');

});

Theme::routes();








