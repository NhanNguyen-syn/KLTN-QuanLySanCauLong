<?php

namespace Botble\CourtBooking\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\CourtBooking\Services\RevenueStatisticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RevenueDashboardController extends BaseController
{
    protected RevenueStatisticsService $statisticsService;

    public function __construct(RevenueStatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Display the revenue dashboard page
     */
    public function index(Request $request)
    {
        $this->pageTitle('Thống kê doanh thu');

        Assets::addScripts(['chart.js'])
            ->addScriptsDirectly('vendor/core/plugins/court-booking/js/revenue-dashboard.js')
            ->addStylesDirectly('vendor/core/plugins/court-booking/css/revenue-dashboard.css');

        $range = $request->input('range', 'this_month');
        $dateRanges = $this->statisticsService->getDateRanges();

        $startDate = $request->input('start_date', $dateRanges[$range]['start'] ?? null);
        $endDate = $request->input('end_date', $dateRanges[$range]['end'] ?? null);

        $summary = $this->statisticsService->getDashboardSummary($startDate, $endDate);
        $topCourts = $this->statisticsService->getTopCourts(5, $startDate, $endDate);
        $revenueByCourt = $this->statisticsService->getRevenueByCourt($startDate, $endDate);

        return view('plugins/court-booking::revenue-dashboard', compact(
            'summary',
            'topCourts',
            'revenueByCourt',
            'dateRanges',
            'range',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Get chart data via AJAX
     */
    public function getChartData(Request $request): JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $chartType = $request->input('chart_type', 'daily');

        if ($chartType === 'monthly') {
            $year = $request->input('year', date('Y'));
            $data = $this->statisticsService->getRevenueByMonth((int) $year);

            // Format for Chart.js
            $labels = [];
            $revenues = [];
            $bookings = [];

            for ($i = 1; $i <= 12; $i++) {
                $monthData = $data->firstWhere('month', $i);
                $labels[] = 'Tháng ' . $i;
                $revenues[] = $monthData?->total_revenue ?? 0;
                $bookings[] = $monthData?->booking_count ?? 0;
            }
        } else {
            $data = $this->statisticsService->getRevenueByDay($startDate, $endDate);

            $labels = $data->pluck('booking_date')->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d/m');
            })->toArray();

            $revenues = $data->pluck('total_revenue')->toArray();
            $bookings = $data->pluck('booking_count')->toArray();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'revenues' => $revenues,
                'bookings' => $bookings,
            ],
        ]);
    }

    /**
     * Get summary statistics via AJAX (for filter updates)
     */
    public function getSummary(Request $request): JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $summary = $this->statisticsService->getDashboardSummary($startDate, $endDate);
        $topCourts = $this->statisticsService->getTopCourts(5, $startDate, $endDate);

        return response()->json([
            'success' => true,
            'summary' => $summary,
            'topCourts' => $topCourts,
        ]);
    }

    /**
     * Export revenue report to Excel/CSV
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $summary = $this->statisticsService->getDashboardSummary($startDate, $endDate);
        $dailyData = $this->statisticsService->getRevenueByDay($startDate, $endDate);
        $topCourts = $this->statisticsService->getTopCourts(10, $startDate, $endDate);

        // Get detailed booking list
        $bookingQuery = \Botble\CourtBooking\Models\BookingList::query();

        if ($startDate) {
            $bookingQuery->whereDate('date', '>=', $startDate);
        }
        if ($endDate) {
            $bookingQuery->whereDate('date', '<=', $endDate);
        }

        $bookingDetails = $bookingQuery
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();

        // Generate CSV
        $filename = 'bao_cao_doanh_thu_' . date('d-m-Y_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($summary, $dailyData, $topCourts, $bookingDetails, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // ===== HEADER =====
            fputcsv($file, ['==============================================']);
            fputcsv($file, ['BÁO CÁO DOANH THU SÂN CẦU LÔNG']);
            fputcsv($file, ['==============================================']);
            fputcsv($file, ['Ngày xuất báo cáo:', date('d/m/Y H:i:s')]);
            fputcsv($file, ['Khoảng thời gian:', ($startDate && $endDate) ? ($startDate . ' đến ' . $endDate) : 'Tất cả']);
            fputcsv($file, []);

            // ===== TỔNG KẾT =====
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, ['I. TỔNG KẾT']);
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, ['Tổng doanh thu:', number_format($summary['total_revenue']) . ' VNĐ']);
            fputcsv($file, ['Tổng số đơn đặt:', $summary['total_bookings'] . ' đơn']);
            fputcsv($file, ['Đơn xác nhận:', $summary['confirmed_bookings'] . ' đơn']);
            fputcsv($file, ['Đơn đã hủy:', $summary['cancelled_bookings'] . ' đơn']);
            fputcsv($file, ['Tỷ lệ xác nhận:', $summary['confirmation_rate'] . '%']);
            fputcsv($file, []);

            // ===== THỐNG KÊ THEO NGÀY =====
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, ['II. THỐNG KÊ THEO NGÀY']);
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, ['Ngày', 'Doanh thu (VNĐ)', 'Số đơn']);

            $totalDailyRevenue = 0;
            $totalDailyBookings = 0;
            foreach ($dailyData as $row) {
                fputcsv($file, [
                    date('d/m/Y', strtotime($row->booking_date)),
                    number_format($row->total_revenue),
                    $row->booking_count,
                ]);
                $totalDailyRevenue += $row->total_revenue;
                $totalDailyBookings += $row->booking_count;
            }
            fputcsv($file, ['TỔNG CỘNG', number_format($totalDailyRevenue), $totalDailyBookings]);
            fputcsv($file, []);

            // ===== TOP SÂN =====
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, ['III. TOP SÂN ĐƯỢC ĐẶT NHIỀU NHẤT']);
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, ['Hạng', 'Tên sân', 'Số lượt đặt', 'Doanh thu (VNĐ)']);

            foreach ($topCourts as $index => $court) {
                fputcsv($file, [
                    $index + 1,
                    $court->court_name,
                    $court->booking_count . ' lượt',
                    number_format($court->total_revenue),
                ]);
            }
            fputcsv($file, []);

            // ===== CHI TIẾT TỪNG ĐƠN =====
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, ['IV. CHI TIẾT TỪNG ĐƠN ĐẶT SÂN']);
            fputcsv($file, ['----------------------------------------------']);
            fputcsv($file, [
                'STT',
                'Mã đơn',
                'Ngày đặt',
                'Giờ bắt đầu',
                'Giờ kết thúc',
                'Tên sân',
                'Khách hàng',
                'Số điện thoại',
                'Giá (VNĐ)',
                'Đã thanh toán (VNĐ)',
                'Trạng thái',
                'Ghi chú'
            ]);

            foreach ($bookingDetails as $index => $booking) {
                $status = match ($booking->status) {
                    'confirmed' => 'Đã xác nhận',
                    'cancelled' => 'Đã hủy',
                    'pending' => 'Chờ xác nhận',
                    default => $booking->status,
                };

                fputcsv($file, [
                    $index + 1,
                    $booking->order_code ?? 'N/A',
                    date('d/m/Y', strtotime($booking->date)),
                    $booking->start_time,
                    $booking->end_time,
                    $booking->court_name,
                    $booking->customer_name ?? 'N/A',
                    $booking->contact ?? 'N/A',
                    number_format($booking->price ?? 0),
                    number_format($booking->paid_amount ?? 0),
                    $status,
                    $booking->notes ?? '',
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['==============================================']);
            fputcsv($file, ['Tổng số đơn trong báo cáo:', count($bookingDetails) . ' đơn']);
            fputcsv($file, ['==============================================']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
