<?php

namespace Database\Seeders;

use Botble\CourtBooking\Models\{Court, CourtStatus, CourtType, PricingRule, TimeSlot};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSystemSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CourtType::truncate();
        CourtStatus::truncate();
        Court::truncate();
        TimeSlot::truncate();
        PricingRule::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Bỏ qua tạo user/role vì hệ thống Botble đã quản lý riêng.

        $typeSingle = CourtType::create(['name' => 'Sân đơn']);
        $typeDouble = CourtType::create(['name' => 'Sân đôi']);

        $statusActive = CourtStatus::create(['name' => 'Đang hoạt động']);
        $statusMaintenance = CourtStatus::create(['name' => 'Bảo trì']);

        Court::create(['name' => 'Sân 1', 'court_type_id' => $typeSingle->id, 'status_id' => $statusActive->id]);
        Court::create(['name' => 'Sân 2', 'court_type_id' => $typeSingle->id, 'status_id' => $statusActive->id]);
        Court::create(['name' => 'Sân 3', 'court_type_id' => $typeDouble->id, 'status_id' => $statusActive->id]);
        Court::create(['name' => 'Sân 4', 'court_type_id' => $typeDouble->id, 'status_id' => $statusMaintenance->id]);

        // Khung giờ 30 phút từ 5h -> 22h
        for ($h = 5; $h < 22; $h++) {
            $start1 = sprintf('%02d:00:00', $h);
            $mid = sprintf('%02d:30:00', $h);
            $end = sprintf('%02d:00:00', $h + 1);
            TimeSlot::create(['label' => sprintf('%02d:00 - %02d:30', $h, $h), 'start_time' => $start1, 'end_time' => $mid, 'days_of_week' => '1,2,3,4,5,6,7']);
            TimeSlot::create(['label' => sprintf('%02d:30 - %02d:00', $h, $h+1), 'start_time' => $mid, 'end_time' => $end, 'days_of_week' => '1,2,3,4,5,6,7']);
        }

        PricingRule::create(['name' => 'Giờ thấp điểm (T2-T6)', 'type' => 'weekday', 'from_time' => '05:00:00', 'to_time' => '17:00:00', 'price' => 50000, 'priority' => 100]);
        PricingRule::create(['name' => 'Giờ cao điểm (T2-T6)', 'type' => 'weekday', 'from_time' => '17:00:00', 'to_time' => '22:00:00', 'price' => 80000, 'priority' => 90]);
        PricingRule::create(['name' => 'Cuối tuần (T7-CN)', 'type' => 'weekend', 'from_time' => '05:00:00', 'to_time' => '22:00:00', 'price' => 90000, 'priority' => 50]);
        PricingRule::create(['name' => 'Ngày lễ', 'type' => 'holiday', 'from_time' => '05:00:00', 'to_time' => '22:00:00', 'price' => 100000, 'priority' => 10]);
    }
}

