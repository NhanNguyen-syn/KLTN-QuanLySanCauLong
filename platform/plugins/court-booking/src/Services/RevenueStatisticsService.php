<?php

namespace Botble\CourtBooking\Services;

use Botble\CourtBooking\Models\BookingList;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RevenueStatisticsService
{
    /**
     * Status values that count as "completed" for revenue
     */
    protected array $completedStatuses = ['completed', 'paid'];

    /**
     * Status values that count as "cancelled"
     */
    protected array $cancelledStatuses = ['cancelled', 'canceled'];

    /**
     * Status values that count as "pending"
     */
    protected array $pendingStatuses = ['pending', 'processing'];

    /**
     * Get total revenue within a date range (only completed/paid orders)
     * Uses paid_amount for actual received money
     */
    public function getTotalRevenue(?string $startDate = null, ?string $endDate = null): float
    {
        $query = BookingList::query()
            ->whereIn('status', $this->completedStatuses);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        // Use paid_amount for actual revenue, fallback to price if paid_amount is null/0
        return (float) $query->sum(DB::raw('COALESCE(NULLIF(paid_amount, 0), price)'));
    }

    /**
     * Get paid amount (actual received money)
     */
    public function getTotalPaidAmount(?string $startDate = null, ?string $endDate = null): float
    {
        $query = BookingList::query()
            ->whereIn('status', $this->completedStatuses);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        return (float) $query->sum('paid_amount');
    }

    /**
     * Get revenue grouped by day
     */
    public function getRevenueByDay(?string $startDate = null, ?string $endDate = null): Collection
    {
        $query = BookingList::query()
            ->select(
                DB::raw('DATE(date) as booking_date'),
                DB::raw('SUM(COALESCE(NULLIF(paid_amount, 0), price)) as total_revenue'),
                DB::raw('COUNT(*) as booking_count')
            )
            ->whereIn('status', $this->completedStatuses)
            ->groupBy('booking_date')
            ->orderBy('booking_date');

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        return $query->get();
    }

    /**
     * Get revenue grouped by month
     */
    public function getRevenueByMonth(int $year): Collection
    {
        return BookingList::query()
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(COALESCE(NULLIF(paid_amount, 0), price)) as total_revenue'),
                DB::raw('COUNT(*) as booking_count')
            )
            ->whereIn('status', $this->completedStatuses)
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get booking statistics
     */
    public function getBookingStats(?string $startDate = null, ?string $endDate = null): array
    {
        $baseQuery = BookingList::query();

        if ($startDate) {
            $baseQuery->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $baseQuery->whereDate('date', '<=', $endDate);
        }

        $totalBookings = (clone $baseQuery)->count();
        $completedBookings = (clone $baseQuery)->whereIn('status', $this->completedStatuses)->count();
        $cancelledBookings = (clone $baseQuery)->whereIn('status', $this->cancelledStatuses)->count();
        $pendingBookings = (clone $baseQuery)->whereIn('status', $this->pendingStatuses)->count();

        return [
            'total' => $totalBookings,
            'confirmed' => $completedBookings, // Keep key name for backward compatibility
            'cancelled' => $cancelledBookings,
            'pending' => $pendingBookings,
            'confirmation_rate' => $totalBookings > 0
                ? round(($completedBookings / $totalBookings) * 100, 1)
                : 0,
        ];
    }

    /**
     * Get top courts by booking count
     */
    public function getTopCourts(int $limit = 5, ?string $startDate = null, ?string $endDate = null): Collection
    {
        $query = BookingList::query()
            ->select(
                'court_id',
                'court_name',
                DB::raw('COUNT(*) as booking_count'),
                DB::raw('SUM(COALESCE(NULLIF(paid_amount, 0), price)) as total_revenue')
            )
            ->whereIn('status', $this->completedStatuses)
            ->groupBy('court_id', 'court_name')
            ->orderByDesc('booking_count')
            ->limit($limit);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        return $query->get();
    }

    /**
     * Get revenue by court
     */
    public function getRevenueByCourt(?string $startDate = null, ?string $endDate = null): Collection
    {
        $query = BookingList::query()
            ->select(
                'court_name',
                DB::raw('SUM(COALESCE(NULLIF(paid_amount, 0), price)) as total_revenue')
            )
            ->whereIn('status', $this->completedStatuses)
            ->groupBy('court_name')
            ->orderByDesc('total_revenue');

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        return $query->get();
    }

    /**
     * Get summary statistics for dashboard cards
     */
    public function getDashboardSummary(?string $startDate = null, ?string $endDate = null): array
    {
        $totalRevenue = $this->getTotalRevenue($startDate, $endDate);
        $bookingStats = $this->getBookingStats($startDate, $endDate);
        $topCourts = $this->getTopCourts(1, $startDate, $endDate);

        return [
            'total_revenue' => $totalRevenue,
            'total_bookings' => $bookingStats['total'],
            'confirmed_bookings' => $bookingStats['confirmed'],
            'cancelled_bookings' => $bookingStats['cancelled'],
            'confirmation_rate' => $bookingStats['confirmation_rate'],
            'top_court' => $topCourts->first()?->court_name ?? 'N/A',
        ];
    }

    /**
     * Get predefined date ranges
     */
    public function getDateRanges(): array
    {
        $today = Carbon::today();

        return [
            'all_time' => [
                'label' => 'Tất cả',
                'start' => null, // No limit - include all past and future
                'end' => null,
            ],
            'today' => [
                'label' => 'Hôm nay',
                'start' => $today->toDateString(),
                'end' => $today->toDateString(),
            ],
            'yesterday' => [
                'label' => 'Hôm qua',
                'start' => $today->copy()->subDay()->toDateString(),
                'end' => $today->copy()->subDay()->toDateString(),
            ],
            'this_week' => [
                'label' => 'Tuần này',
                'start' => $today->copy()->startOfWeek()->toDateString(),
                'end' => $today->toDateString(),
            ],
            'last_week' => [
                'label' => 'Tuần trước',
                'start' => $today->copy()->subWeek()->startOfWeek()->toDateString(),
                'end' => $today->copy()->subWeek()->endOfWeek()->toDateString(),
            ],
            'this_month' => [
                'label' => 'Tháng này',
                'start' => $today->copy()->startOfMonth()->toDateString(),
                'end' => $today->toDateString(),
            ],
            'last_month' => [
                'label' => 'Tháng trước',
                'start' => $today->copy()->subMonth()->startOfMonth()->toDateString(),
                'end' => $today->copy()->subMonth()->endOfMonth()->toDateString(),
            ],
            'this_year' => [
                'label' => 'Năm nay',
                'start' => $today->copy()->startOfYear()->toDateString(),
                'end' => $today->toDateString(),
            ],
        ];
    }
}
