<?php

namespace Botble\CourtBooking\Tables;

use Botble\CourtBooking\Models\CourtSlot;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\FormattedColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class CourtSlotTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(CourtSlot::class)
            ->addColumns([
                IdColumn::make(),

                // Cột Sân
                FormattedColumn::make('court')
                    ->label('Sân')
                    ->getValueUsing(fn($item) => optional($item->court)->name ?? '-'),

                // Cột Ngày
                FormattedColumn::make('date')
                    ->label('Ngày')
                    ->getValueUsing(function ($item) {
                        if (!$item->start_at) {
                            return '-';
                        }
                        $start = $item->start_at instanceof Carbon ? $item->start_at : Carbon::parse($item->start_at);
                        return $start->format('d/m/Y');
                    }),

                // Cột Giờ bắt đầu
                FormattedColumn::make('start_time')
                    ->label('Giờ bắt đầu')
                    ->getValueUsing(function ($item) {
                        if (!$item->start_at) {
                            return '-';
                        }
                        $start = $item->start_at instanceof Carbon ? $item->start_at : Carbon::parse($item->start_at);
                        return $start->format('H:i');
                    }),

                // Cột Giờ kết thúc
                FormattedColumn::make('end_time')
                    ->label('Giờ kết thúc')
                    ->getValueUsing(function ($item) {
                        if (!$item->end_at) {
                            return '-';
                        }
                        $end = $item->end_at instanceof Carbon ? $item->end_at : Carbon::parse($item->end_at);
                        return $end->format('H:i');
                    }),

                // Cột Trạng thái slot
                FormattedColumn::make('status')
                    ->label('Trạng thái')
                    ->getValueUsing(function ($item) {
                        $statusLabels = [
                            'available' => '<span class="badge bg-success">Có sẵn</span>',
                            'reserved' => '<span class="badge bg-warning">Đã giữ</span>',
                            'booked' => '<span class="badge bg-primary">Đã đặt</span>',
                            'blocked' => '<span class="badge bg-danger">Bị khóa</span>',
                        ];
                        return $statusLabels[$item->status] ?? $item->status;
                    }),

                // Cột Khách hàng
                FormattedColumn::make('customer')
                    ->label('Khách hàng')
                    ->getValueUsing(function ($item) {
                        $booking = $item->getBooking();
                        if (!$booking || !$booking->user) {
                            return '-';
                        }
                        return $booking->user->name ?? $booking->user->email ?? '-';
                    }),

                // Cột Liên hệ
                FormattedColumn::make('contact')
                    ->label('Liên hệ')
                    ->getValueUsing(function ($item) {
                        $booking = $item->getBooking();
                        if (!$booking || !$booking->user) {
                            return '-';
                        }
                        return $booking->user->phone ?? $booking->user->email ?? '-';
                    }),

                // Cột Giá (Guest/Member)
                FormattedColumn::make('price')
                    ->label('Giá (Guest/Member)')
                    ->getValueUsing(function ($item) {
                        $guestPrice = number_format((float)($item->base_price ?? 0), 0, '.', ',');
                        $memberPrice = number_format((float)($item->member_price ?? 0), 0, '.', ',');
                        return "{$guestPrice} / {$memberPrice}";
                    }),

                // Cột Đã thanh toán
                FormattedColumn::make('payment_status')
                    ->label('Đã thanh toán')
                    ->getValueUsing(function ($item) {
                        $booking = $item->getBooking();
                        if (!$booking) {
                            return '-';
                        }

                        $statusLabels = [
                            'pending' => '<span class="badge bg-warning">Chờ thanh toán</span>',
                            'paid' => '<span class="badge bg-success">Đã thanh toán</span>',
                            'cancelled' => '<span class="badge bg-danger">Đã hủy</span>',
                            'refunded' => '<span class="badge bg-info">Đã hoàn tiền</span>',
                        ];

                        return $statusLabels[$booking->status] ?? $booking->status;
                    }),

                // Cột Ghi chú
                FormattedColumn::make('notes')
                    ->label('Ghi chú')
                    ->getValueUsing(function ($item) {
                        $booking = $item->getBooking();
                        if (!$booking || !$booking->notes) {
                            return '-';
                        }
                        // Giới hạn độ dài hiển thị
                        $notes = $booking->notes;
                        return strlen($notes) > 50 ? substr($notes, 0, 50) . '...' : $notes;
                    }),
            ])
            ->addActions([
                EditAction::make()->route('court-slot.edit'),
                DeleteAction::make()->route('court-slot.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('court-slot.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                // Eager load relationships để tránh N+1 query
                $query->with(['court', 'bookingItems.booking.user']);

                // Filter theo court_id
                $courtId = (int) request()->get('court_id');
                if ($courtId) {
                    $query->where('court_id', $courtId);
                }

                // Filter theo date
                $date = request()->get('date');
                if ($date) {
                    $query->whereDate('start_at', $date);
                }

                // Filter theo status
                $status = request()->get('status');
                if ($status) {
                    $query->where('status', $status);
                }

                // Sắp xếp theo ngày và giờ
                $query->orderBy('start_at', 'asc');
            });
    }
}

