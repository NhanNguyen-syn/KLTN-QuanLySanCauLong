<?php

namespace Botble\CourtBooking\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\CourtBooking\Forms\BookingListForm;
use Botble\CourtBooking\Http\Requests\BookingListRequest;
use Botble\CourtBooking\Models\BookingList;
use Botble\CourtBooking\Tables\BookingListTable;
use Botble\CourtBooking\Services\InvoicePdfService;
use Exception;
use Illuminate\Http\Request;

class BookingListController extends BaseController
{
    public function __construct()
    {
        $this->middleware('core.permission:booking-list.destroy')->only('destroy');
    }

    public function index(BookingListTable $table)
    {
        $this->pageTitle(trans('plugins/court-booking::booking-list.name'));

        return $table->renderTable();
    }

    public function edit(BookingList $bookingList, Request $request)
    {
        event(new BeforeEditContentEvent($request, $bookingList));

        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $bookingList->order_code]));

        $siblings = BookingList::query()
            ->where('order_code', $bookingList->order_code)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        // Prefer the row that actually has customer info; fallback to the first row
        $orderInfo = $siblings->firstWhere(fn($item) => !empty($item->customer_name) || !empty($item->contact))
            ?: $siblings->first()
            ?: $bookingList;

        return view('plugins/court-booking::edit', [
            'form' => BookingListForm::createFromModel($bookingList),
            'booking' => $bookingList,
            'items' => $siblings,
            'orderInfo' => $orderInfo,
        ]);
    }

    public function update(BookingList $bookingList, BookingListRequest $request, BaseHttpResponse $response)
    {
        // Nếu admin chọn cập nhật theo mã đơn (phân bổ tiền cọc cho toàn bộ mục)
        if ($request->boolean('apply_to_order')) {
            $orderCode = $bookingList->order_code;
            $totalPaid = (float) $request->input('paid_amount_total', 0);

            $siblings = BookingList::query()
                ->where('order_code', $orderCode)
                ->orderBy('date')
                ->orderBy('start_time')
                ->get();

            $totalPrice = (float) $siblings->sum('price');
            $allocatedSoFar = 0;
            foreach ($siblings as $idx => $it) {
                $alloc = $totalPrice > 0 ? round($totalPaid * ($it->price / $totalPrice), 2) : 0;
                // Điều chỉnh phần dư cho item cuối
                if ($idx === ($siblings->count() - 1)) {
                    $alloc = max(0, $totalPaid - $allocatedSoFar);
                }
                $allocatedSoFar += $alloc;

                $it->paid_amount = $alloc;
                // Đồng bộ status & notes nếu được cung cấp
                if ($request->filled('status'))
                    $it->status = $request->input('status');
                if ($request->filled('notes'))
                    $it->notes = $request->input('notes');
                $it->save();
            }

            event(new UpdatedContentEvent(\BOOKING_LIST_MODULE_SCREEN_NAME, $request, $bookingList));

            return $response
                ->setPreviousUrl(route('booking-list.index'))
                ->setMessage('Đã cập nhật tiền cọc cho toàn bộ đơn hàng.');
        }

        // Cập nhật đơn lẻ: đồng bộ trạng thái cho tất cả mục cùng mã đơn
        $bookingList->fill($request->input());
        $bookingList->save();

        if ($request->filled('status')) {
            BookingList::query()
                ->where('order_code', $bookingList->order_code)
                ->update(['status' => $request->input('status')]);
        }

        event(new UpdatedContentEvent(\BOOKING_LIST_MODULE_SCREEN_NAME, $request, $bookingList));

        return $response
            ->setPreviousUrl(route('booking-list.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(BookingList $bookingList, Request $request, BaseHttpResponse $response)
    {
        try {
            // Booking list index is grouped by order_code, so deleting a row should delete the whole order
            $orderCode = $bookingList->order_code;

            BookingList::query()
                ->where('order_code', $orderCode)
                ->delete();

            event(new DeletedContentEvent(\BOOKING_LIST_MODULE_SCREEN_NAME, $request, $bookingList));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * Print invoice as PDF
     */
    public function printInvoice(BookingList $bookingList, InvoicePdfService $invoiceService)
    {
        return $invoiceService->streamPdf($bookingList);
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice(BookingList $bookingList, InvoicePdfService $invoiceService)
    {
        return $invoiceService->downloadPdf($bookingList);
    }

    /**
     * Send invoice via email
     */
    public function sendInvoiceEmail(BookingList $bookingList, Request $request, InvoicePdfService $invoiceService, BaseHttpResponse $response)
    {
        $email = $request->input('email', $bookingList->contact);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $response->setError()->setMessage('Email không hợp lệ.');
        }

        $sent = $invoiceService->sendEmail($bookingList, $email);

        if ($sent) {
            return $response->setMessage('Đã gửi hóa đơn đến ' . $email);
        } else {
            return $response->setError()->setMessage('Không thể gửi email. Vui lòng thử lại.');
        }
    }
}
