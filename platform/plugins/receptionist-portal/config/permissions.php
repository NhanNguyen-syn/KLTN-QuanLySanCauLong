<?php

return [
    [
        'name' => 'Cổng Lễ tân',
        'flag' => 'receptionist.index',
    ],
    [
        'name' => 'Check-in',
        'flag' => 'receptionist.checkin',
        'parent_flag' => 'receptionist.index',
    ],
    [
        'name' => 'Thanh toán',
        'flag' => 'receptionist.payment',
        'parent_flag' => 'receptionist.index',
    ],
    [
        'name' => 'Đặt sân nhanh',
        'flag' => 'receptionist.quick-booking',
        'parent_flag' => 'receptionist.index',
    ],
    [
        'name' => 'Quản lý VIP',
        'flag' => 'receptionist.vip',
        'parent_flag' => 'receptionist.index',
    ],
];
