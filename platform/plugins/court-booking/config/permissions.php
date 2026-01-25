<?php

return [
    // Courts CRUD
    [
        'name' => 'Courts',
        'flag' => 'courts.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'courts.create',
        'parent_flag' => 'courts.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'courts.edit',
        'parent_flag' => 'courts.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'courts.destroy',
        'parent_flag' => 'courts.index',
    ],

    // Booking List
    [
        'name' => 'Danh sách đặt sân',
        'flag' => 'booking-list.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'booking-list.edit',
        'parent_flag' => 'booking-list.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'booking-list.destroy',
        'parent_flag' => 'booking-list.index',
    ],

    // Services
    [
        'name' => 'Dịch vụ & Sản phẩm',
        'flag' => 'services.index',
    ],
    [
        'name' => 'Tạo mới',
        'flag' => 'services.create',
        'parent_flag' => 'services.index',
    ],
    [
        'name' => 'Chỉnh sửa',
        'flag' => 'services.edit',
        'parent_flag' => 'services.index',
    ],
    [
        'name' => 'Xóa',
        'flag' => 'services.destroy',
        'parent_flag' => 'services.index',
    ],

    // Revenue Dashboard - đã chuyển sang plugin revenue-statistics
];
