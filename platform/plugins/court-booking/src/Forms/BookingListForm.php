<?php

namespace Botble\CourtBooking\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\CourtBooking\Models\BookingList;

class BookingListForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new BookingList())
            ->withCustomFields();

        // Thêm bảng tổng hợp các mục cùng mã đơn vào ngay đầu form (đảm bảo luôn thấy đủ các sân/khung giờ)
        $booking = $this->getModel();
        if ($booking && $booking->order_code) {
            $items = BookingList::query()
                ->where('order_code', $booking->order_code)
                ->orderBy('date')
                ->orderBy('start_time')
                ->get();

            $statusLabels = [
                'pending' => 'Chờ xử lý',
                'processing' => 'Đang xử lý',
                'confirmed' => 'Đã Check-in',
                'paid' => 'Đã cọc',
                'completed' => 'Hoàn tất',
                'cancelled' => 'Đã hủy',
            ];
            $statusColors = [
                'pending' => 'warning',
                'processing' => 'warning',
                'confirmed' => 'primary',
                'paid' => 'info',
                'completed' => 'success',
                'cancelled' => 'danger',
            ];

            $totalPrice = ($items ?? collect())->sum('price');
            $totalPaid  = ($items ?? collect())->sum('paid_amount');

            $this->addHtml(view('plugins/court-booking::partials.order_items', compact(
                'booking', 'items', 'statusLabels', 'statusColors', 'totalPrice', 'totalPaid'
            ))->render());
        }

        // Trường admin có thể chỉnh
        $this

            ->add('status', 'customSelect', [
                'label' => 'Trạng thái',
                'required' => true,
                'choices' => [
                    'pending' => 'Chờ xử lý',
                    'processing' => 'Đang xử lý',
                    'confirmed' => 'Đã Check-in',
                    'paid' => 'Đã cọc',
                    'completed' => 'Hoàn tất',
                    'cancelled' => 'Đã hủy',
                ],
            ])
            ->add('notes', 'textarea', [
                'label' => 'Ghi chú',
                'attr' => [
                    'rows' => 3,
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}

